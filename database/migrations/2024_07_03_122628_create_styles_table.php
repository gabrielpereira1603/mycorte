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
        Schema::create('style', function (Blueprint $table) {
            $table->id();
            $table->string('colorText', '20');
            $table->string('logo', '120');
            $table->string('name', '100');
            $table->string('primaryColor', '20');
            $table->string('secondaryColor', '20');
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
        Schema::dropIfExists('styles');
    }
};
