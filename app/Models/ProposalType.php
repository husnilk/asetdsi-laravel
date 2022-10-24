<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalType extends Model
{
    // use HasFactory;
    protected $table = "proposal_type"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = ['type_name'
    ];
}
