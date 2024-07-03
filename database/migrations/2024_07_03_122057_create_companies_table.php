<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('city', '120');
            $table->string('cnpj', '14');
            $table->string('localization', '999');
            $table->string('name', '120');
            $table->string('neighborhood', '120');
            $table->string('road', '120');
            $table->string('number', '20');
            $table->string('state', '120');
            $table->string('zipCode', '120');
            $table->string('token', '255');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company');
    }
};
