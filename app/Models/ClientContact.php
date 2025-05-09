<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientContact extends Model
{
    protected $fillable = [
        'client_id', 'first_name', 'last_name', 'email',
        'phone', 'position', 'is_primary'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

