<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    // use HasFactory;
    protected $table = "pengadaan"; //cek
    protected $primaryKey = "id_pengadaan"; //cek
    protected $fillable = ['keterangan_pengadaan','surat_pengadaan','status','id_mahasiswa'
    ];
}
