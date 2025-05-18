<?php

namespace App\Imports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LeadsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Lead([
            'name' => $row['name'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'address' => $row['address'] ?? null,
            'position' => $row['position'] ?? null,
            'company' => $row['company'],
            'website' => $row['website'],
            'description' => $row['description'],
            'value' => $row['value'] ?? 0,
            'assigned_to' => $row['assigned_to'] ?? null,
            'country' => $row['country'] ?? null,
            'status' => $row['status'] ?? 'New',
            'source' => $row['source'] ?? null,
            'city' => $row['city'] ?? null,
            'state' => $row['state'] ?? null,
            'zip' => $row['zip'] ?? null,
            'language' => $row['language'] ?? 'English',
            'is_public' => $row['is_public'] ?? 'Yes',
        ]);
    }
}
