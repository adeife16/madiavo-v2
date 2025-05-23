<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstimateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'created_by' => 'required|exists:users,id',
            'sale_agent' => 'nullable|exists:users,id',
            'estimate_date' => 'required|date',
            'reference_no' => 'nullable|string|max:255',
            'discount_percent' => 'nullable|numeric|min:0',
            'discount_total' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:before_tax,after_tax',
            'adjustment' => 'nullable|numeric',
            'client_note' => 'nullable|string',
            'admin_note' => 'nullable|string',
            'terms' => 'nullable|string',
            'billing_street' => 'nullable|string',
            'billing_city' => 'nullable|string',
            'billing_state' => 'nullable|string',
            'billing_zip' => 'nullable|string',
            'billing_country_id' => 'nullable|exists:countries,id',
            'shipping_street' => 'nullable|string',
            'shipping_city' => 'nullable|string',
            'shipping_state' => 'nullable|string',
            'shipping_zip' => 'nullable|string',
            'shipping_country_id' => 'nullable|exists:countries,id',
            'show_shipping_on_estimate' => 'nullable|boolean',
        ];
    }
}
