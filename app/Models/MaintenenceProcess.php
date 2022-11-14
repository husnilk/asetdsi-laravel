<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenenceProcess extends Model
{
    // use HasFactory;
    protected $table = "maintenence_process"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = ['proposal_id','status'
    ];
}
