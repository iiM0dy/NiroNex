<?php

namespace App\Models;

use App\Enums\MessageType;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'title',
        'body',
        'target_user_ids',
        'is_read',
        'type',
    ];

    protected $cast = [
        'is_read' => 'boolean',
        'type' => MessageType::class,
        'target_user_ids' => 'array'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
