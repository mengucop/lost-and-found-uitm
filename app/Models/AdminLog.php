<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin;


class AdminLog extends Model
{
    protected $table = 'admin_logs';

    protected $fillable = [
        'admin_id',
        'item_id',
        'action',
        'ip_address',
        'user_agent'
    ];

    public function admin()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'admin_id');
    }


}


