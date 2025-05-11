<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'iso2',
        'short_name',
        'long_name',
        'iso3',
        'num_code',
        'un_member',
        'calling_code',
        'cctld',
    ];
    
}
