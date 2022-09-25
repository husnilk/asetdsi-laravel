<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    // use HasFactory;

      protected $table = "inventory_item"; //cek
      protected $primaryKey = "inventory_item_id"; //cek
      protected $fillable = ['item_code','condition','available',
     'inventory_id','location_id','pic_id'
      ];
}
