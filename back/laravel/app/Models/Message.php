<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'emisor',
        'texto',
        'chat_id',
        'id_message',
        'editado',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'emisor');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    // public function receiver()
    // {
    //     return $this->belongsTo(User::class, 'receiver_id');
    // }
}
