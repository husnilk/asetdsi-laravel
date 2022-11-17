<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    // use HasFactory;
    protected $table = "notifications"; //cek
    protected $primaryKey = "id"; //cek
    protected $fillable = ['sender_id','sender','receiver_id','receiver','message','object_type_id','object_type','read_at'
    ];
}
