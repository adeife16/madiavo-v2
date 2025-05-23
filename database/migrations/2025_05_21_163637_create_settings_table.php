<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('key')->unique(); // e.g. estimate_default_prefix, general_timezone
            $table->text('value')->nullable(); // Store strings, numbers, JSON etc.

            $table->string('module')->nullable(); // Optional grouping: 'estimates', 'invoices', 'general'
            $table->string('type')->default('string'); // string, json, boolean, integer, etc.

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};
