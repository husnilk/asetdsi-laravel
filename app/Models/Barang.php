<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    // use HasFactory;
        // use HasFactory;
        protected $table = "barang"; //cek
        protected $primaryKey = "id_barang"; //cek
        protected $fillable = ['merk_barang','keterangan','no_aset','tgl_perolehan','asal_perolehan','harga_aset',
        'kondisi_aset','foto'
        ];
}
