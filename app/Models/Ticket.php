<?php

namespace App\Models;

use App\Enums\TicketSubTypeEnum;
use App\Enums\TicketTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'message',
        'subject',
        'sub_type',
        'type',
        'closed_at',
        'client_id',
        'user_id'
    ];

    protected $casts = [
        'closed_at' => 'datetime',
        'sub_type' => TicketSubTypeEnum::class,
        'type' => TicketTypeEnum::class
    ];

    //relations
    public function issuers()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function replies(){
        return  $this->hasMany(Reply::class);
    }
}
