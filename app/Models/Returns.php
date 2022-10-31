<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    // use HasFactory;

    protected $table = "returns"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = ['loan_id','status'
    ];
}
