<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prospek extends Model
{
    protected $table = 'prospek';


     public function user()
    {
        return $this->belongsTo(User::class,'userid','userid');
    }

    public function lead()
    {
        return $this->hasOne(Lead::class,'id','leadsid');
    }


}
