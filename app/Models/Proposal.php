<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{

     // use HasFactory;
     protected $table = "proposal"; //cek
     protected $primaryKey = "id"; //cek
     protected $fillable = ['proposal_description','status','mahasiswa_id',
     'pic_id','type_id','admins_id'
     ];
}
