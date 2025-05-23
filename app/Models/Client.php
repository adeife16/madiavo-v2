<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'company',
        'phonenumber',
        'vat',
        'country',
        'city',
        'zip',
        'state',
        'address',
        'website',
        'datecreated',
        'active',
        'leadid',
        'billing_street',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'shipping_street',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'longitude',
        'latitude',
        'default_language',
        'default_currency',
        'show_primary_contact',
        'stripe_id',
        'registration_confirmed',
        'addedfrom'
    ];

    public function contacts()
    {
        return $this->hasMany(ClientContact::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class, "country", "id");
    }
}
