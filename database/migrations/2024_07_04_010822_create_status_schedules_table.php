<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('status_schedule', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['Agendado', 'Cancelado', 'Reagendado', 'Finalizado']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('status_schedule');
    }
};
