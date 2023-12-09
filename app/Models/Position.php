<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{

	public function user()
    {
        return $this->belongsTo(User::class,'id','user_d');
    }

}
