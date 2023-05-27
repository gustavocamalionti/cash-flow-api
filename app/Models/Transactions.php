<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'sender_user_id',
        'receiver_user_id',
        'amount',
        'status_id'
    ];

    public function sendUser()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function receiverUser()
    {
        return $this->belongsTo(User::class, 'receiver_user_id');
    }
}
