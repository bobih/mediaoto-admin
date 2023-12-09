<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function brands()
    {
        return $this->hasOne(Brands::class, 'id', 'brand_id');
    }

    public function prospek()
    {
        return $this->hasMany(Prospek::class, 'userid', 'id');
    }


    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function position()
    {
        return $this->hasOne(Position::class, 'id', 'position_id');
    }



    public function province()
    {
        return $this->hasOne(Province::class, 'id', 'province_id');
    }

    public function listposition()
    {
        return $this->hasMany(ListPosition::class, 'parent_id');
    }





}
