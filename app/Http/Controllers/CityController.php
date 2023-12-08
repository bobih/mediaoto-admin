<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Province;
use DB;

class CityController extends Controller
{

 public function getCity(Request $request){


	$request = $request->get('query');
    $q = DB::table('cities')->where('provinces_id', $request)->get(['id', DB::raw('name as text')]);

    return $q;
}

}
