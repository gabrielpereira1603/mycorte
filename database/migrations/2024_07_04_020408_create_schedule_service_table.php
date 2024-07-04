<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedule_service', function (Blueprint $table) {
            $table->foreignId('schedule_id')->constrained('schedule')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('service')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule_service');
    }
};
