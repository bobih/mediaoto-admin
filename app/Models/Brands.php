<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Encore\Admin\Layout\Content;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{

 use HasFactory;
        //use ModelTree;


         protected $table = 'brands';


	public function user()
    {
        return $this->belongsTo(User::class,'brand_id');
    }


        public function showroom()
    {
        return $this->belongsTo(Showroom::class,'brand_id');
    }


}
