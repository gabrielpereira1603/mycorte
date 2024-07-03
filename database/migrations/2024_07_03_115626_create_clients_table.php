<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('client', function (Blueprint $table) {
            $table->id();
            $table->string('name', '100');
            $table->string('email', '100');
            $table->string('password', '255');
            $table->string('telephone', '30');
            $table->string('image', '100')->nullable();
            $table->enum('role', ['CLIENT'])->default('CLIENT')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client');
    }
};
