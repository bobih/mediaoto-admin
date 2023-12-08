<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProspekController extends Controller
{

    public function getSummary(Request $request)
    {
        $userid =  $request['userid'];

        //Summary Total
        $total = DB::table('prospek')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where('userid', $userid)->first();

        //Summary Total Har Ini
        $total_today = DB::table('prospek')
                    ->select(DB::raw('COUNT(id) as total'))
                    ->where(DB::raw('DATE(`created_at`) = CURRENT_DATE()'))
                    ->where('userid',$userid)->first();


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


        $reminder = DB::table('reminder')
                        ->select( DB::raw('count(reminder.leadsid) as total'))
                        ->leftJoin('prospek', 'prospek.id', '=', 'reminder.leadsid')
                        ->where('prospek.userid', $userid)
                        ->where(DB::raw('DATE(reminder.tanggal)'),'>=',' CURDATE()')
                        ->groupBy('reminder.userid')
                        ->first();

        $reminder_today = DB::table('reminder')
                        ->select( DB::raw('count(*) as total'))
                        ->leftJoin('prospek', 'prospek.id', '=', 'reminder.leadsid')
                        ->where('prospek.userid', $userid)
                        ->where(DB::raw('DATE(reminder.tanggal)'),'=',' CURDATE()')
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


        ];

        return response()->json($data, 200);
    }



}
