<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    // use HasFactory;
    protected $table = "building"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = ['building_name','building_code','serial_number','condition','available','photo','asset_id','pic_id'
    ];
}

