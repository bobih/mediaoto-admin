<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProspekController extends Controller
{

    public function getSummary(Request $request)
    {
        $userid = $request['userid'];

        //Summary Total
        $total = DB::table('prospek')
            ->select(DB::raw('COUNT(id) as total'))
            ->where('userid', $userid)
            ->where('lost', 0)->first();

        //Summary Total Har Ini
        $total_today = DB::table('prospek')
            ->select(DB::raw('COUNT(id) as total'))
            ->where(DB::raw('DATE(`created_at`) = CURRENT_DATE()'))
            ->where('userid', $userid)->first();


        //NEW
        $baru = DB::table('prospek')
            ->select(DB::raw('COUNT(id) as total'))
            ->where('view', 0)
            ->where('userid', $userid)->first();

        $baru_today = DB::table('prospek')
            ->select(DB::raw('COUNT(id) as total'))
            ->where('view', 0)
            ->where(DB::raw('DATE(`created_at`) = CURRENT_DATE()'))
            ->where('userid', $userid)->first();

        // VIEW
        $viewed = DB::table('prospek')
            ->select(DB::raw('COUNT(id) as total'))
            ->where('view', 1)
            ->where('userid', $userid)->first();


        $viewed_today = DB::table('prospek')
            ->select(DB::raw('COUNT(id) as total'))
            ->where('view', 1)
            ->where(DB::raw('DATE(`created_at`) = CURRENT_DATE()'))
            ->where('userid', $userid)->first();


        // Lost
        $Lost = DB::table('prospek')
        ->select(DB::raw('COUNT(id) as total'))
        ->where('userid', $userid)
        ->where('lost','>', 0)->first();

        $lost_today = DB::table('prospek')
            ->select(DB::raw('COUNT(id) as total'))
            ->where(DB::raw('DATE(`created_at`) = CURRENT_DATE()'))
            ->where('userid', $userid)
            ->where('lost','>', 0)->first();


        //CAll
        $reminder = DB::table('reminder')
            ->select(DB::raw('count(reminder.leadsid) as total'))
            ->leftJoin('prospek', 'prospek.id', '=', 'reminder.leadsid')
            ->where('prospek.userid', $userid)
            ->where(DB::raw('DATE(reminder.tanggal)'), '>=', ' CURDATE()')
            ->groupBy('reminder.userid')
            ->first();

        $reminder_today = DB::table('reminder')
            ->select(DB::raw('count(*) as total'))
            ->leftJoin('prospek', 'prospek.id', '=', 'reminder.leadsid')
            ->where('prospek.userid', $userid)
            ->where(DB::raw('DATE(reminder.tanggal)'), '=', ' CURDATE()')
            ->groupBy('reminder.userid')
            ->first();


        $data = [
            [
                "id" => 1,
                "title" => "Semua Prospek",
                "total" => $total->total,
                "today" => $total_today->total
            ],
            [
                "id" => 2,
                "title" => "Baru",
                "total" => $baru->total,
                "today" => $baru_today->total
            ],
            [
                "id" => 3,
                "title" => "Sudah Pernah Dilihat",
                "total" => $viewed->total,
                "today" => $viewed_today->total
            ],

            [
                "id" => 5,
                "title" => "Lost",
                "total" => $Lost->total,
                "today" => $lost_today->total
            ],

            /*
            [
                "id" => 4,
                "title" => "Telepon Kembali",
                "total" => $reminder,
                "today" => $reminder_today,
            ],

            [
                "id" => 5,
                "title" => "Tes Jalan",
                "total" => 1,
                "today" => 0
            ],


            [
                "id" => 6,
                "title" => "Tidak Ada Langkah yang Ditentukan",
                "total" => 1,
                "today" => 0
            ],


            [
                "id" => 7,
                "title" => "Pembaruan",
                "total" => 0,
                "today" => 0
            ]
            */
        ];

        $data = json_decode(json_encode($data), true);

        /*
        array_walk_recursive($data, function (&$item) {
            $item = strval($item);
        });
        */
       // $data = json_encode($data);

        return response()->json($data, 200);
    }


    public function getList(Request $request)
    {

        $userid = $request['userid'];
        $listid = $request['listid'];


        $result = DB::table('prospek')
            ->select('leads.*', 'prospek.view', 'prospek.created_at as regdate', 'prospek.favorite', 'prospek.id as pid')
            ->leftJoin('leads', 'leads.id', '=', 'prospek.leadsid');

        switch ($listid) {
            case 0:
                $result->where('prospek.userid', '=', $userid);
                $result->orderBy('prospek.id', 'desc');
                break;
            case 1:

                $result->where('prospek.view', '=', 0);
                $result->where('prospek.userid', '=', $userid);
                $result->orderBy('prospek.id', 'desc');
                break;
            case 2:

                $result->where('prospek.view', '=', 1);
                $result->where('prospek.userid', '=', $userid);
                $result->orderBy('prospek.id', 'desc');
                break;
            case 3:
                $sql = "SELECT `leads`.*,`prospek`.`view`, `prospek`.`favorite`, `prospek`.`created_at` as regdate, `prospek`.`id` as pid
                        FROM `prospek` LEFT JOIN `leads` ON `leads`.`id` = `prospek`.`leadsid`
                        LEFT JOIN `reminder` ON `prospek`.`id`= `reminder`.`leadsid`
                        WHERE `prospek`.`userid`='" . $userid . "' AND DATE(`reminder`.`tanggal`) >= CURDATE()
                        GROUP BY `reminder`.`leadsid`;";

                $result = DB::table('prospek')
                    ->select('leads.*', 'reminder.leadsid', 'prospek.view', 'prospek.created_at as regdate', 'prospek.favorite', 'prospek.id as pid')
                    ->leftJoin('leads', 'leads.id', '=', 'prospek.leadsid')
                    ->leftJoin('reminder', 'prospek.id', '=', 'reminder.leadsid')
                    ->where('prospek.userid', '=', $userid)
                    ->whereDate('reminder.tanggal', '>=', 'CURDATE()');

                break;
            case 4:
                //$sql .= " WHERE prospek.userid='0' ";
                $result->where('prospek.userid', '=', 0);
                $result->orderBy('prospek.id', 'desc');
                break;
        }

        $return = json_decode($result->get());
        $data = [];
        $x = 0;
        foreach ($return as $rows) {
            $data[$x]['id'] = $rows->pid;
            $data[$x]['nama'] = trim(ucwords($rows->name));
            $data[$x]['mobile'] = $rows->phone;
            $data[$x]['car'] = $rows->model . " " . html_entity_decode($rows->variant);
            $data[$x]['model'] = $rows->model;
            $data[$x]['type'] = html_entity_decode($rows->variant);
            $data[$x]['lokasi'] = $rows->city;
            $data[$x]['angsuran'] = "0";
            $data[$x]['tenor'] = "0";
            $data[$x]['tdp'] = "0";
            $data[$x]['favorite'] = $rows->favorite;
            $data[$x]['view'] = $rows->view;
            $data[$x]['regdate'] = $rows->regdate;
            $x++;
        }


        array_walk_recursive($data, function (&$item) {
            $item = strval($item);
        });
        $data = json_encode($data);

      return response($data,200)->withHeaders([
        'Content-Type' => 'text/html; charset=UTF-8',
        'X-Header-One' => 'Header Value',
        'X-Header-Two' => 'Header Value',
    ]);
        //return response()->json($data, 200)->header('Content-Type', 'text/html; charset=UTF-8');

    }


    public function setFavorite(Request $request)
    {

        $leadid = $request['leadid'];
        $userid = $request['userid'];
        $status = $request['status'];

        // Update Status as View
        $affected = DB::table('prospek')
            ->where('prospek.id', $leadid)
            ->where('prospek.userid', $userid)
            ->update(['favorite' => $status]);

        if ($affected == 1) {
            return response()->json(["message" => "Data Updated"], 200);
        } else {
            return response()->json(["Error" => "Update Failed"], 401);
        }
    }


    public function setNote(Request $request)
    {

        $affected = DB::table('prospek')
            ->where('prospek.id', $request['leadid'])
            ->update(['note' => $request['note']]);

        if ($affected == 1) {
            return response()->json(["message" => "Data Updated"], 200);
        } else {
            return response()->json(["Error" => "Update Failed"], 401);
        }
    }


    public function setLost(Request $request)
    {

        $affected = DB::table('prospek')
            ->where('prospek.id', $request['leadid'])
            ->update(['lost' => $request['lost']]);

        if ($affected == 1) {
            return response()->json(["message" => "Data Updated"], 200);
        } else {
            return response()->json(["Error" => "Update Failed"], 401);
        }
    }

    public function setReminder(Request $request)
    {

        DB::table('reminder')->insert([
            'leadsid' => $request['leadid'],
            'userid' => $request['userid'],
            'notifid' => $request['notifid'],
            'tanggal' => $request['tanggal']
        ]);
        return response()->json(["message" => "Data Updated"], 200);
    }

    public function phoneLog(Request $request)
    {

        DB::table('list_call')->insert([
            'leadsid' => $request['leadid'],
            'userid' => $request['userid'],
            'tanggal' => date("Y-m-d H:i:s")
        ]);

        return response()->json(["message" => "Data Updated"], 200);
    }

    public function waLog(Request $request)
    {

        DB::table('list_wa')->insert([
            'leadsid' => $request['leadid'],
            'userid' => $request['userid'],
            'tanggal' => date("Y-m-d H:i:s")
        ]);

        return response()->json(["message" => "Data Updated"], 200);
    }

    public function getFavorite(Request $request)
    {
        $userid = $request['userid'];

        // Get Data
        $result = DB::table('prospek')
            ->select('leads.*', 'prospek.view', 'prospek.created_at as regdate', 'prospek.favorite', 'prospek.id as pid')
            ->leftJoin('leads', 'leads.id', '=', 'prospek.leadsid')
            ->where('prospek.userid', '=', $userid)
            ->where('prospek.favorite', '=', 1)
            ->orderBy('prospek.id', 'desc');


        $return = json_decode($result->get());

        $data = [];
        $x = 0;
        foreach ($return as $rows) {
            $data[$x]['id'] = $rows->pid;
            $data[$x]['nama'] = trim(ucwords($rows->name));
            $data[$x]['mobile'] = $rows->phone;
            $data[$x]['car'] = $rows->model . " " . html_entity_decode($rows->variant);
            $data[$x]['model'] = $rows->model;
            $data[$x]['type'] = html_entity_decode($rows->variant);
            $data[$x]['lokasi'] = $rows->city;
            $data[$x]['angsuran'] = "0";
            $data[$x]['tenor'] = "0";
            $data[$x]['tdp'] = "0";
            $data[$x]['favorite'] = $rows->favorite;
            $data[$x]['view'] = $rows->view;
            $data[$x]['regdate'] = $rows->regdate;
            $x++;
        }

        array_walk_recursive($data, function (&$item) {
            $item = strval($item);
        });
        return response()->json($data, 200);
    }

    public function getLeadById(Request $request)
    {

        $leadid = $request['leadid'];
        $userid = $request['userid'];

        $updateProspek = DB::table('prospek')
            ->where('prospek.id', $leadid)
            ->update(['view' => 1]);

        $result = DB::table('prospek')
            ->select('leads.*', 'prospek.view', 'prospek.created_at as regdate', 'prospek.favorite', 'prospek.note', 'prospek.id as pid')
            ->leftJoin('leads', 'leads.id', '=', 'prospek.leadsid')
            ->where('prospek.id', '=', $leadid);

        $return = json_decode($result->get());

        $data = [];
        $x = 0;
        foreach ($return as $rows) {
            $data[$x]['id'] = $rows->pid;
            $data[$x]['nama'] = trim( ucwords($rows->name));
            $data[$x]['nickname'] = '';
            $data[$x]['email'] = '';
            $data[$x]['mobile'] =  $rows->phone;
            $data[$x]['car'] = $rows->model . " " . html_entity_decode($rows->variant);
            $data[$x]['lokasi'] = $rows->city;
            $data[$x]['angsuran'] = "0";
            $data[$x]['tenor'] = "0";
            $data[$x]['tdp'] = "0";
            $data[$x]['favorite'] = $rows->favorite;
            $data[$x]['view'] = $rows->view;
            $data[$x]['regdate'] =  $rows->regdate;
            $data[$x]['lastview'] =  "2023-11-17 10:10:10";
            $data[$x]['catatan'] = $rows->note;
            $x++;
        }

        $reminder = DB::table('reminder')
            ->select('*')
            ->where('leadsid', '=', $leadid)
            ->where('userid', '=', $userid)
            ->orderBy('tanggal', 'desc');

            $data[0]['reminder'] = $reminder->get();
        $data = json_decode(json_encode($data), true);
        array_walk_recursive($data, function (&$item) {
            $item = strval($item);
        });
        return response()->json($data, 200);
    }

    public function searchLeads(Request $request)
    {

        $search = $request['search'];
        $userid = $request['userid'];

        $result = DB::table('prospek')
            ->select('leads.*', 'prospek.view', 'prospek.created_at as regdate', 'prospek.favorite', 'prospek.id as pid')
            ->leftJoin('leads', 'leads.id', '=', 'prospek.leadsid')
            ->where('prospek.userid', '=', $userid)
            ->where('leads.name', 'like', "%" . $search . "%");

        $return = json_decode($result->get());

        $data = [];
        $x = 0;
        foreach ($return as $rows) {
            $data[$x]['id'] = $rows->pid;
            $data[$x]['nama'] = trim(ucwords($rows->name));
            $data[$x]['mobile'] = $rows->phone;
            $data[$x]['car'] = $rows->model . " " . html_entity_decode($rows->variant);
            $data[$x]['model'] = $rows->model;
            $data[$x]['type'] = html_entity_decode($rows->variant);
            $data[$x]['lokasi'] = $rows->city;
            $data[$x]['angsuran'] = "0";
            $data[$x]['tenor'] = "0";
            $data[$x]['tdp'] = "0";
            $data[$x]['favorite'] = $rows->favorite;
            $data[$x]['view'] = $rows->view;
            $data[$x]['regdate'] = $rows->regdate;
            $x++;
        }

        array_walk_recursive($data, function (&$item) {
            $item = strval($item);
        });
        return response()->json($data, 200);

    }


}
