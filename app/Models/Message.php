<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'sender_id',
        'receiver_id',
        'message',
        'image', // ✅ Add this line
        'read_at' // (optional if you're using it)
    ];

    public function sender()
    {
        return $this->belongsTo(Student::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Student::class, 'receiver_id');
    }
}
