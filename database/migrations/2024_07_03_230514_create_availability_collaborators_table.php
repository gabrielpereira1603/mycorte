<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('availability_collaborator', function (Blueprint $table) {
            $table->id();
            $table->time('hourStart');
            $table->time('hourFinal');
            $table->time('hourServiceInterval');
            $table->time('hourInterval');
            $table->enum('workDays', ['Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado', 'Domingo']);
            $table->unsignedBigInteger('collaboratorfk');
            $table->foreign('collaboratorfk')->references('id')->on('collaborator')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availability_collaborator');
    }
};
