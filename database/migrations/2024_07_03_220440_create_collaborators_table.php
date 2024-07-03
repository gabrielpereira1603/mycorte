<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collaborator', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->boolean('enabled')->default(true);
            $table->string('image', '120')->nullable();
            $table->string('name', '100');
            $table->string('password');
            $table->enum('role', ['ADMIN', 'COLLABORATOR']);
            $table->string('telephone', '60');
            $table->unsignedBigInteger('companyfk');
            $table->foreign('companyfk')->references('id')->on('company')->onDelete('cascade');
            $table->timestamps();

            // Restrição única para o email
            $table->unique('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collaborators');
    }
};
