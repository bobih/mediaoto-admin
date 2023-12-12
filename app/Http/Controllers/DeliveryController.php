<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Response;
class DeliveryController extends Controller
{
    public function test()
    {

      //$userModel = new User();

        $debug = true;
        $userid = 61;// 60;
        $requestDate = '2019-06-01'; // Request DATA
        $tanggal = '';// '2023-12-07 00:15:33'; // Start Push - empty to push now
        $dailypush = 4;

        $user = User::where('id', $userid)->first();

        if(empty($user)){
          return "User Not Exist";
        }

        $brand = $user['brand'];
        if($brand == ''){
          return "Brand Not Exist";
        }
        $quota = $user['quota'];
        if($quota == ''){
          return "Quota Not Exist";
        }

        if($debug){
          //echo '<h1>DEBUG MODE</h1>';
          //echo "<pre>";
          //print_r($user);
          //echo "</pre>";
        }



        if($tanggal==''){
          $tanggal = date('Y-m-d');
        } else {
          $tanggal = strtotime($tanggal);
        $tanggal = date('Y-m-d',$tanggal);

        }


        if($debug){
            echo '<h1>DEBUG MODE</h1>';
            echo "<pre>";
            print_r(json_decode(json_encode($user)));
            echo "</pre>";

            //Check if user Already on list push

            $total = DB::table('list_push')
            ->select(DB::raw('COUNT(DISTINCT userid) as total'))
            ->where('userid', $userid)
            ->groupBy('userid');

            echo $total->toRawSql();

 //           echo "<pre>";
 //           print_r($total);
 //           echo "</pre>";


            /*
            $newquery = "SELECT count(*) as total from push_list where userid = '".$userid."' group by userid ";
            $pushinfo = $db->query($newquery)->getRow();
            //echo $pushinfo['total'];
            if($pushinfo->total > 0){
            echo '<h1>WARNING user Already in list ('.$pushinfo->total.')</h1>';
            }
            */
          }


        // Set start and end times
        $startTime = '09:00:00';
        $endTime = '21:00:00';
        // Set the number of days to generate timestamps for
        $numberOfDays = 90;

        // Generate 2 random timestamps for each day in the next 30 days
        $timestamps = [];
        for ($day = 0; $day < $numberOfDays; $day++) {
           $date =date('Y-m-d', strtotime("+$day day", strtotime($tanggal)));

            // total Push daily
           for($y=0; $y < $dailypush; $y++){
             $data[]['tanggal'] = $this->randomTimestamp("$date $startTime", "$date $endTime");
            }
        }

        $query = DB::table('leads')
                ->select('leads.id','brands.brand', 'leads.model','leads.variant','leads.create')
                ->leftJoin('brands', 'brands.id', '=', 'leads.brand')
                ->where('leads.brand', $brand)
                ->where('leads.create','>=',$requestDate)
                ->whereNotIn('leads.id',  function($q) use ($userid){
                    $q->select('leadsid')->from('prospek')->where('userid', $userid);
                })
                ->orderBy('leads.create','asc')->limit($quota)->get();
                //return

                $query = DB::table('leads')
                ->select('leads.id','brands.brand', 'leads.model','leads.variant','leads.create')
                ->leftJoin('brands', 'brands.id', '=', 'leads.brand')
                ->where('leads.brand', $brand)
                ->where('leads.create','>=',$requestDate)
                ->whereNotIn('leads.id',  function($q) use ($userid){
                    $q->select('leadsid')->from('prospek')
                    ->where('userid', $userid)
                    ->where('userid', 60);
                })
                ->orderBy('leads.id','desc')->limit($quota)->get();


       // $query = $db->query($sql)->getResultArray();
       //return response()->json($query, 200);
       //$data = $query->toArray();

       //return view('delivery',$data);
       /*
                echo "<pre>";
                print_r($query);
                echo "</pre>";
        */

       // echo $data[0];
       $newarr = [];
        for($x=0; $x < count($query);  $x++ ){
           // echo $query[$x]->id;

            /*
          $newarr[$x]['tanggal'] =   $data[$x]['tanggal'];
          $newarr[$x]['leadsid'] =  $query[$x]->id;
          $newarr[$x]['userid'] =  $userid;
          $newarr[$x]['nama'] =   $user['nama'];
          $newarr[$x]['data'] =   $query[$x]->create;
          $newarr[$x]['brand'] =  $query[$x]->brand . " " . $query[$x]->model . " " . $query[$x]->variant;
            */

            /*

            $sql = "INSERT INTO `prospek`
                SET `prospek`.`userid`='" . $userid . "',
                    `prospek`.`leadsid` = '" . $leadsid . "',
                    `prospek`.`created_at` = NOW(),
                    `prospek`.`updated_at` = NOW()";
        $query = $db->query($sql);

            */

            $sql = "INSERT INTO `prospek`
            SET `prospek`.`userid`='" . $userid . "',
                `prospek`.`leadsid` = '" . $query[$x]->id . "',
                `prospek`.`created_at` = NOW(),
                `prospek`.`updated_at` = NOW();";

            echo "<br />" . $sql;

          if($debug){



          } else {
            //$saveData = $this->insertPushList($userid, $query[$x]['id'],$data[$x]['tanggal']);
          }
        }


        // Insert Database;


        echo "<pre>";
        print_r($newarr);
        echo "</pre>";


        // Output the generated timestamps
      //  foreach ($timestamps as $date => $dayTimestamps) {
      //      echo "Date: $date, Timestamp 1: {$dayTimestamps['timestamp1']}, Timestamp 2: {$dayTimestamps['timestamp2']}" . "<br />";
      //  }


    }


    private function randomTimestamp($startTime, $endTime)
    {
        $startTimestamp = strtotime($startTime);
        $endTimestamp = strtotime($endTime);

        $randomTimestamp = mt_rand($startTimestamp, $endTimestamp);

        return date('Y-m-d H:i:s', $randomTimestamp);
    }

    private function insertPushList($userid, $leadsid, $tanggal){


        DB::table('list_push')->insert([
            'leadsid' => $leadsid,
            'userid' => $userid,
            'tanggal' => $tanggal
        ]);
        return response()->json(["message" => "Data Updated"], 200);

    }


}
