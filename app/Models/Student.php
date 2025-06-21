<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    public $timestamps = false;

    public function studentItems()
    {
        return $this->hasMany(Item::class);
    }

    public function sentClaims()
    {
        return $this->hasMany(Claim::class, 'claimed_by');
    }

    public function receivedClaims()
    {
        return $this->hasMany(Claim::class, 'claimed_to');
    }
}
