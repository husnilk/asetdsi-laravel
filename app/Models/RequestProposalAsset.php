<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestProposalAsset extends Model
{
    // use HasFactory;
    protected $table = "request_proposal_asset"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = ['asset_name','spesification_detail','amount',
    'unit_price','source_shop','proposal_id'
    ];
}
