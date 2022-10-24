<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{

    use HasApiTokens, HasFactory, Notifiable;

    // use HasFactory;
    protected $table = "mahasiswa"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = [
        'nim',
        'name',
        'email',
        'username',
        'password',
        'remember_token'
    ];
}
