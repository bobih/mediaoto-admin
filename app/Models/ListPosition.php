<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListPosition extends Model
{
    protected $table = 'list_positions';

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function parent()
    {
        return $this->hasOne(User::class,'id','parent_id');
    }
}
