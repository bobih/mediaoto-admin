<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function getAds() {

        $data = [
            [
                "id" => 1,
                "title" => "ads1",
                "image" => "",
                "url" => ""
            ],
            [
                "id" => 2,
                "title" => "ads2",
                "image" => "",
                "url" => ""
            ],
            [
                "id" => 3,
                "title" => "ads3",
                "image" => "",
                "url" => ""
            ]
        ];

        //$data = [];

        $response = json_encode($data,JSON_NUMERIC_CHECK);

        return $this->respond($response, 200);

    }
}
