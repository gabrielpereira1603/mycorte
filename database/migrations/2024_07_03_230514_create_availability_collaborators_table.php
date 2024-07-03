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
            $table->time('hourStart', '0');
            $table->time('hourFinal', '0');
            $table->time('hourServiceInterval', '0');
            $table->time('hourInterval', '0');
            $table->enum('workDays', ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo']);
            $table->unsignedBigInteger('collaboratorfk');
            $table->foreign('collaboratorfk')->references('id')->on('collaborator');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('availability_collaborator');
    }
};
