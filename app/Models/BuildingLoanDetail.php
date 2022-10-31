<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingLoanDetail extends Model
{
    // use HasFactory;
      // use HasFactory;
      protected $table = "building_loan_detail"; //cek
      protected $primaryKey = "id"; //cek
      protected $fillable = ['building_id','loan_id'
      ];
}
