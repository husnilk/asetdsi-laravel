<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    // use HasFactory;
    protected $table = "asset_type"; //cek
    protected $primaryKey = "type_id"; //cek
    protected $fillable = ['type_name'
    ];
}
