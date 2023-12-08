<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{


 public function prospek()
    {
        return $this->belongsTo(Prospeks::class,'leadsid');
    }



}
