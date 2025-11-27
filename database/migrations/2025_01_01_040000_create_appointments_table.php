<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('service_id')->constrained();
            $table->foreignId('advisor_id')->nullable()->constrained('users');
            $table->date('scheduled_date');
            $table->string('scheduled_time');
            $table->string('channel')->default('web');
            $table->string('status')->default('reservado');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
