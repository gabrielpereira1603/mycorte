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
        Schema::create('promotion', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('dataHourStart');
            $table->dateTime('dataHourFinal');
            $table->decimal('value', 10, 2);
            $table->unsignedBigInteger('servicefk');
            $table->foreign('servicefk')->references('id')->on('service')->onDelete('cascade');
            $table->unsignedBigInteger('companyfk');
            $table->foreign('companyfk')->references('id')->on('company')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion');
    }
};
