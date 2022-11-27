<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    // use HasFactory;
    protected $table = "loan"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = ['loan_date','loan_description','loan_time',
   'mahasiswa_id','type_id','pic_id','status','loan_time_end'
    ];
}
