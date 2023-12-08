<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{


    public function user()
    {
        return $this->belongsTo(User::class,'city_id');
    }



     public function province()
    {
        return $this->belongsTo(Province::class,'provinces_id');
    }

    public function showroom()
    {
        return $this->belongsTo(Showroom::class,'city_id');
    }


}
