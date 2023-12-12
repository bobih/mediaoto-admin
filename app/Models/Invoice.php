<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';

    public function username()
    {
        return $this->belongsTo(User::class,'userid');
    }

    public function createdname()
    {
        return $this->belongsTo(User::class,'createdby');
    }

    public function paketname()
    {
        return $this->belongsTo(ListPaket::class,'paketid');
    }

    public function approvedname()
    {
        return $this->belongsTo(user::class,'approvedby');
    }

}
