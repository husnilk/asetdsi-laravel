<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // use HasFactory;
    protected $guard = 'admin';
    protected $table = "admins"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = [
        'nip',
        'name',
        'email',
        'phone_number', 
        'username',
        'password',
        'remember_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
