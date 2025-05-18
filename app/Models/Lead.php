<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'position',
        'company',
        'website',
        'tags',
        'value',
        'assigned_to',
        'source',
        'country',
        'city',
        'state',
        'zip',
        'status',
        'description',
        'converted_to_client',
        'contacted_at',
        'language',
        'is_public',
    ];

    public function assignedStaff()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
