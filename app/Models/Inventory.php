<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    // use HasFactory;
    protected $table = "inventory"; //cek
    protected $primaryKey = "inventory_id"; //cek
    protected $fillable = ['inventory_brand','inventory_code','serial_number','condition','available',
    'photo','asset_id','location_id','pic_id'
    ];
}
