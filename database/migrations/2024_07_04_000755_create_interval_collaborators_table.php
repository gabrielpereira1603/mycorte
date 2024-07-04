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
        Schema::create('interval_collaborator', function (Blueprint $table) {
            $table->id();
            $table->string('reason', '50');
            $table->time('hourStart');
            $table->time('hourFinal');
            $table->date('date',);
            $table->unsignedBigInteger('collaboratorfk');
            $table->foreign('collaboratorfk')->references('id')->on('collaborator')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interval_collaborator');
    }
};
