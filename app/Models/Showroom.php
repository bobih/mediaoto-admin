<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Showroom extends Model
{


    public function brands()
    {
        return $this->hasOne(Brands::class,'id','brand_id');
    }

    public function province()
    {
       // return $this->hasOne(Province::class,'id','province');
    }


    public function city()
    {
        return $this->hasOne(City::class,'id','city_id'); // SELECT * FROM cities where city.xx
    }

}
