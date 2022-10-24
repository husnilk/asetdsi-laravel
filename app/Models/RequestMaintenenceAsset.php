<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestMaintenenceAsset extends Model
{
    // use HasFactory;
        // use HasFactory;
        protected $table = "request_maintenence_asset"; //cek
        protected $primaryKey = "id"; //cek
        protected $fillable = ['problem_description','proposal_id','inventory_item_id'
        ];
    }

