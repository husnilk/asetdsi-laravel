<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    protected $table = "photos"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = ['photo_name','req_maintenence_id'
    ];
    // use HasFactory;
}
