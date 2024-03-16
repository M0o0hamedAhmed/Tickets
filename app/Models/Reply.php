<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;


    protected $fillable =[
        'id',
        'message',
        'user_id',
        'created_at',
        'ticket_id'
    ];

}
