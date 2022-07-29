<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPengadaan extends Model
{
    // use HasFactory;
    protected $table = "request_pengadaan"; //cek
    protected $primaryKey = "id_request"; //cek
    protected $fillable = ['nama_barang','jumlah_barang','id_pengadaan'];
}
