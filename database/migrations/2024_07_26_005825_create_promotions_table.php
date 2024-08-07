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
            $table->boolean('enabled')->default(true);
            $table->enum('type', ['individual', 'combo']);
            $table->unsignedBigInteger('companyfk');
            $table->foreign('companyfk')->references('id')->on('company')->onDelete('cascade');
            $table->unsignedBigInteger('collaboratorfk');
            $table->foreign('collaboratorfk')->references('id')->on('collaborator')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('service_promotion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_id')->constrained('service')->onDelete('cascade');
            $table->foreignId('promotion_id')->constrained('promotion')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_promotion');
        Schema::dropIfExists('promotion');
    }
};
