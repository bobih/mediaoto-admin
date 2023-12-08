<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{


    public function user()
    {
        return $this->belongsTo(User::class,'id','province_id');
    }



    public function city()
    {
        return $this->hasOne(City::class,'id','provinces_id');
    }

    public function province()
    {
        return $this->belongsTo(Showroom::class,'province');
    }

    



}
