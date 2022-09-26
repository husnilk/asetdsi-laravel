<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
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
