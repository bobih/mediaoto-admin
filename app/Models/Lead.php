<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{


 public function prospek()
    {
        return $this->belongsTo(Prospek::class,'leadsid');
    }

    public function brands()
    {
        return $this->hasOne(Brands::class, 'id', 'brand');
    }

}
