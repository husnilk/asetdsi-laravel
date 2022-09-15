<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonInCharge extends Model
{
    // use HasFactory;
    protected $table = "person_in_charge"; //cek
    protected $primaryKey = "pic_id "; //cek
    protected $fillable = [
        'pic_name',
        'username',
        'email',
        'password',
        'remember_token'
    ];
}
