<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_options';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $casts = [
        'witget' => 'object',
    ];
    protected $guarded = [];
}
