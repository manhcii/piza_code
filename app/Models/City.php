<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'states';
    protected $guarded = [];
    protected $casts = [
        'json_params' => 'object',
    ];
}
