<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectedProposal extends Model
{
    // use HasFactory;
    protected $table = "rejected_proposal"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = ['reasons','proposal_id'
    ];
}
