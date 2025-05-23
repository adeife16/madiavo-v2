<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'module', 'type'];

    protected $casts = [
        'value' => 'string',  // You can override this dynamically if needed
    ];
}
