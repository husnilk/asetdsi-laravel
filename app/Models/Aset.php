<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    // use HasFactory;
    // use HasFactory;
    protected $table = "aset"; //cek
    protected $primaryKey = "id_aset"; //cek
    protected $fillable = ['kode_aset','nama_barang','id_jenis'
    ];
}
