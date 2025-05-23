<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('estimates', function (Blueprint $table) {
            $table->id();

            // References
            $table->foreignId('client_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained('currencies')->cascadeOnDelete();
            $table->foreignId('sale_agent')->nullable()->constrained('users')->nullOnDelete();

            // Identification
            $table->integer('number');
            $table->string('prefix')->nullable();
            $table->string('formatted_number')->unique();
            $table->string('reference_no')->nullable();
            $table->string('hash', 32)->unique();

            // Dates
            $table->date('estimate_date');
            $table->date('expiry_date')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('invoiced_at')->nullable();

            // Financials
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('total_tax', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('discount_percent', 5, 2)->default(0);
            $table->decimal('discount_total', 15, 2)->default(0);
            $table->string('discount_type', 30)->nullable(); // e.g., before_tax, after_tax
            $table->decimal('adjustment', 15, 2)->default(0);

            // Status
            $table->unsignedTinyInteger('status')->default(1); // enum in app logic
            $table->boolean('is_sent')->default(false);
            $table->boolean('is_expiry_notified')->default(false);

            // Notes
            $table->text('client_note')->nullable();
            $table->text('admin_note')->nullable();
            $table->text('terms')->nullable();

            // Billing & Shipping
            $table->string('billing_street')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip')->nullable();
            $table->foreignId('billing_country_id')->nullable()->constrained('countries')->nullOnDelete();

            $table->string('shipping_street')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_zip')->nullable();
            $table->foreignId('shipping_country_id')->nullable()->constrained('countries')->nullOnDelete();

            $table->boolean('show_shipping_on_estimate')->default(false);

            // Acceptance
            $table->string('acceptance_firstname')->nullable();
            $table->string('acceptance_lastname')->nullable();
            $table->string('acceptance_email')->nullable();
            $table->timestamp('acceptance_date')->nullable();
            $table->string('acceptance_ip')->nullable();
            $table->text('signature')->nullable();

            $table->string('short_link')->nullable(); // optional sharing link

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estimates');
    }
};