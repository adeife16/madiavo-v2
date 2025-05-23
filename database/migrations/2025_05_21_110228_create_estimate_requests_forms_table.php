<?php
// database/migrations/2025_05_20_000002_create_estimate_request_forms_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('estimate_request_forms', function (Blueprint $table) {
            $table->id();
            $table->string('form_key', 32)->unique();
            $table->string('type', 100)->default('default');  // web, embedded, api
            $table->string('name');
            $table->json('form_data')->nullable();  // stores questions/fields
            $table->boolean('recaptcha')->default(false);
            $table->boolean('status')->default(true);
            $table->string('submit_btn_name')->nullable();
            $table->string('submit_btn_bg_color', 10)->default('#84c529');
            $table->string('submit_btn_text_color', 10)->default('#ffffff');
            $table->text('success_submit_msg')->nullable();
            $table->unsignedTinyInteger('submit_action')->default(0);  // 0: show msg, 1: redirect
            $table->text('submit_redirect_url')->nullable();
            $table->string('language')->nullable();
            $table->timestamp('date_added')->useCurrent();
            $table->string('notify_type', 100)->nullable();  // e.g., 'email', 'user', 'both'
            $table->json('notify_ids')->nullable();  // store as array of emails or user IDs
            $table->foreignId('responsible')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('notify_on_submit')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('estimate_request_forms');
    }
};
