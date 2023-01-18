<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    protected $table = "returns";
    protected $primaryKey = "id";
    protected $fillable = ['loan_id','status'
    ];
}
