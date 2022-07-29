<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    // use HasFactory;
    protected $table = "mahasiswa"; //cek
    protected $primaryKey = "id_mahasiswa"; //cek
    protected $fillable = ['nim','nama','angkatan','organisasi','tgl_lahir','alamat', 'username', 'password'];
}
