<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectedLoan extends Model
{
    // use HasFactory;
    protected $table = "rejected_loan"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = ['reasons','loan_id'
    ];

}
