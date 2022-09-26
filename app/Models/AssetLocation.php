<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetLocation extends Model
{
    // use HasFactory;
    protected $table = "asset_location"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = ['location_name'
    ];
}
