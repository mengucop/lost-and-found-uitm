<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Student extends Model
{
    // … your existing code …

    /**
     * Always store passwords as Bcrypt hashes.
     */
    public function setPasswordAttribute($value)
    {
        // If it’s not already a Bcrypt hash, hash it:
        if (! Hash::info($value)['algo']) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }
}
