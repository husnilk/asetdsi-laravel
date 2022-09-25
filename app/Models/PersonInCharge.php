<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class PersonInCharge  extends Authenticatable
{

    use HasApiTokens, HasFactory, Notifiable;
    // use HasFactory;
    // protected $guard = 'pj';
    protected $table = "person_in_charge"; //cek
    protected $primaryKey = "pic_id "; //cek
    protected $fillable = [
        'pic_name',
        'username',
        'email',
        'password',
        'remember_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
