<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    // use HasFactory;
    protected $table = "asset"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = ['asset_name','type_id'
    ];
    
}
