<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('estimate_request_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->unsignedInteger('status_order')->default(0);
            $table->string('color', 10)->nullable();
            $table->string('flag', 30)->nullable();  // internal identifier
        });
    }

    public function down()
    {
        Schema::dropIfExists('estimate_request_statuses');
    }
};
