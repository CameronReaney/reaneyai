<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Download extends Model
{
    protected $fillable = [
        'resource_name',
        'ip_address',
        'user_agent',
    ];
}
