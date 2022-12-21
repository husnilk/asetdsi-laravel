<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnAssetDetail extends Model
{
    protected $table = "return_asset_detail"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = ['asset_loan_detail_id','returns_id','status'
    ];
}
