<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    // use HasFactory;

      
    protected $table = "inventory"; //cek
    protected $primaryKey = "inventory_id"; //cek
    protected $fillable = ['inventory_brand','photo','asset_id'
    ];
}
