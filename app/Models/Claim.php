<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'claimed_by',
        'claimed_to',
        'pic',
        'status',
    ];

    public function fromStudent()
    {
        return $this->belongsTo(Student::class, 'claimed_by', 'email');
    }

    public function toStudent()
    {
        return $this->belongsTo(Student::class, 'claimed_to', 'email');
    }

    public function item()
    {
    return $this->belongsTo(\App\Models\Item::class, 'item_id');
    }

}
