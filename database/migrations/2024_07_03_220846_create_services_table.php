<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('service', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->time('time');
            $table->double('value');
            $table->boolean('enabled')->default(true);
            $table->unsignedBigInteger('collaboratorfk');
            $table->foreign('collaboratorfk')->references('id')->on('collaborator')->onDelete('cascade');
            $table->timestamps();

            // Restrição única para name e collaboratorfk combinados
            $table->unique(['name', 'collaboratorfk']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service');
    }
};
