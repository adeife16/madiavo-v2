<?php

namespace App\Services;

use App\Models\Estimate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class EstimateService
{
    public function create(array $data): Estimate
    {
        return DB::transaction(function () use ($data) {
            // Step 1: Generate estimate number
            $number = $this->getNextEstimateNumber();
            $prefix = setting('estimate_prefix', 'EST-');
            $formattedNumber = $this->formatEstimateNumber($number, $prefix);

            // Step 2: Apply defaults from settings
            $expiryDays = setting('estimate_due_after', 7);
            $clientNote = setting('estimate_client_note_default', '');
            $terms = setting('estimate_terms_default', '');

            // Step 3: Build estimate data
            $estimateData = [
                'client_id' => $data['client_id'],
                'created_by' => $data['created_by'],
                'sale_agent' => $data['sale_agent'] ?? null,
                'number' => $number,
                'formatted_number' => $formattedNumber,
                'reference_no' => $data['reference_no'] ?? null,
                'hash' => Str::random(32),
                'estimate_date' => Carbon::parse($data['estimate_date']),
                'expiry_date' => Carbon::parse($data['estimate_date'])->addDays($expiryDays),
                'subtotal' => $data['subtotal'] ?? 0,
                'total_tax' => $data['total_tax'] ?? 0,
                'total' => $data['total'] ?? 0,
                'discount_percent' => $data['discount_percent'] ?? 0,
                'discount_total' => $data['discount_total'] ?? 0,
                'discount_type' => $data['discount_type'] ?? null,
                'adjustment' => $data['adjustment'] ?? 0,
                'status' => setting('estimate_default_status', 1),
                'client_note' => $data['client_note'] ?? $clientNote,
                'admin_note' => $data['admin_note'] ?? null,
                'terms' => $data['terms'] ?? $terms,
                // billing/shipping info (optional)
                'billing_street' => $data['billing_street'] ?? null,
                'billing_city' => $data['billing_city'] ?? null,
                'billing_state' => $data['billing_state'] ?? null,
                'billing_zip' => $data['billing_zip'] ?? null,
                'billing_country_id' => $data['billing_country_id'] ?? null,
                'shipping_street' => $data['shipping_street'] ?? null,
                'shipping_city' => $data['shipping_city'] ?? null,
                'shipping_state' => $data['shipping_state'] ?? null,
                'shipping_zip' => $data['shipping_zip'] ?? null,
                'shipping_country_id' => $data['shipping_country_id'] ?? null,
                'show_shipping_on_estimate' => $data['show_shipping_on_estimate'] ?? false,
            ];

            // Step 4: Create the estimate
            $estimate = Estimate::create($estimateData);

            return $estimate;
        });
    }

    protected function getNextEstimateNumber(): int
    {
        $lastNumber = Estimate::max('number');

        return $lastNumber ? $lastNumber + 1 : (int) setting('estimate_starting_number', 1);
    }

    protected function formatEstimateNumber(int $number, string $prefix): string
    {
        $format = setting('estimate_number_format', 'year_based');  // options: plain, year_based
        if ($format === 'year_based') {
            return $prefix.now()->year.'-'.str_pad($number, 4, '0', STR_PAD_LEFT);
        }

        return $prefix.str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function update(Estimate $estimate, array $data): Estimate
    {
        $estimate->update($data);

        return $estimate;
    }

    public function delete(Estimate $estimate): void
    {
        $estimate->delete();
    }
}
