<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();  // maps to userid
            $table->string('company', 200);
            $table->string('vat', 50)->nullable();
            $table->string('phonenumber', 30)->nullable();
            $table->unsignedInteger('country')->default(0);
            $table->string('city', 100)->nullable();
            $table->string('zip', 15)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('address', 191)->nullable();
            $table->string('website', 150)->nullable();
            $table->dateTime('datecreated');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->unsignedInteger('leadid')->nullable();
            $table->string('billing_street', 200)->nullable();
            $table->string('billing_city', 100)->nullable();
            $table->string('billing_state', 100)->nullable();
            $table->string('billing_zip', 100)->nullable();
            $table->unsignedInteger('billing_country')->default(0);
            $table->string('shipping_street', 200)->nullable();
            $table->string('shipping_city', 100)->nullable();
            $table->string('shipping_state', 100)->nullable();
            $table->string('shipping_zip', 100)->nullable();
            $table->unsignedInteger('shipping_country')->default(0);
            $table->string('longitude', 191)->nullable();
            $table->string('latitude', 191)->nullable();
            $table->string('default_language', 40)->nullable();
            $table->unsignedInteger('default_currency')->default(0);
            $table->boolean('show_primary_contact')->default(0);
            $table->string('stripe_id', 40)->nullable();
            $table->boolean('registration_confirmed')->default(1);
            $table->unsignedInteger('addedfrom')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
