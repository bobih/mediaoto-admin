<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListAds;

class AppController extends Controller
{
    public function getAds(Request $request)
    {

        $ads = ListAds::where('active', 1)->get();


        $data = [];
        $x = 0;
        foreach ($ads as $rows) {

            $data[$x]['id'] = $rows->id;
            $data[$x]['title'] = $rows->title;
            $data[$x]['image'] = $rows->image;
            $data[$x]['url'] = $rows->url;
            $x++;
        }
        array_walk_recursive($data, function (&$item) {
            $item = strval($item);
        });
        // Change number to integed
        $data = json_decode(json_encode($data, JSON_NUMERIC_CHECK));
        return response()->json($data, 200);
    }
}
