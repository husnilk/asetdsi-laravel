<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admin extends Model
{
    // use HasFactory;
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
}
