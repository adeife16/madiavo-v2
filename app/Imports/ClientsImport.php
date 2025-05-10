<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientsImport implements ToCollection, WithHeadingRow
{
    public array $imported = [];
    public array $errors = [];

    public function collection(Collection $rows)
    {
        $rowNumber = 1;

        foreach ($rows as $row) {
            $rowNumber++;

            $data = $row->toArray();

            $validator = Validator::make($data, [
                'company' => 'nullable|string',
                'vat' => 'nullable|string',
                'phonenumber' => 'nullable|string',
                'country' => 'required|integer',
                'city' => 'nullable|string',
                'zip' => 'nullable|string',
                'state' => 'nullable|string',
                'address' => 'nullable|string',
                'website' => 'nullable|url',
                'billing_street' => 'nullable|string',
                'billing_city' => 'nullable|string',
                'billing_state' => 'nullable|string',
                'billing_zip' => 'nullable|string',
                'billing_country' => 'nullable|integer',
                'shipping_street' => 'nullable|string',
                'shipping_city' => 'nullable|string',
                'shipping_state' => 'nullable|string',
                'shipping_zip' => 'nullable|string',
                'shipping_country' => 'nullable|integer',
                'longitude' => 'nullable|string',
                'latitude' => 'nullable|string',
                'default_language' => 'nullable|string',
                'default_currency' => 'nullable|integer',
                'show_primary_contact' => 'nullable|boolean',
            ]);

            if ($validator->fails()) {
                $this->errors[] = [
                    'row' => $rowNumber,
                    'errors' => $validator->errors()->all(),
                ];
                continue;
            }

            $this->imported[] = array_merge($validator->validated(), [
                'datecreated' => now(),
                'active' => 1,
                'registration_confirmed' => 1,
                'addedfrom' => auth()->id() ?? 0,
            ]);
        }
    }
}
