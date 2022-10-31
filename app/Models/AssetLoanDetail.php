<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetLoanDetail extends Model
{
    // use HasFactory;
    protected $table = "asset_loan_detail"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = ['inventory_item_id','loan_id'
    ];
}
