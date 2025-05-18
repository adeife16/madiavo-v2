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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->string('position')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('company')->nullable();
            $table->string('website')->nullable();
            $table->text('tags')->nullable();
            $table->string('value')->nullable();
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->unsignedBigInteger('source')->nullable();
            $table->string('status')->default('New');
            $table->unsignedBigInteger('country')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->text('description')->nullable();
            $table->boolean('converted_to_client')->default(false);
            $table->timestamp('contacted_at')->nullable();
            $table->foreign('assigned_to')->references('id')->on('users')->onDelete('set null');
            $table->enum('language', ['English', 'Lithuanian', 'Default'])->default('English');
            $table->enum('is_public', ['Yes', 'No'])->default('No');
            $table->foreign('country')->references('id')->on('countries')->onDelete('no action');
            $table->foreign('source')->references('id')->on('leads_source')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
