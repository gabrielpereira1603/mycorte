<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('hourStart');
            $table->time('hourFinal');
            $table->dateTime('scheduled_at');
            $table->boolean('reminderEmailSent')->default(false);
            $table->unsignedBigInteger('clientfk');
            $table->unsignedBigInteger('collaboratorfk');
            $table->unsignedBigInteger('statusSchedulefk');
            $table->unsignedBigInteger('companyfk');
            $table->foreign('clientfk')->references('id')->on('client')->onDelete('cascade');
            $table->foreign('collaboratorfk')->references('id')->on('collaborator')->onDelete('cascade');
            $table->foreign('statusSchedulefk')->references('id')->on('status_schedule')->onDelete('cascade');
            $table->foreign('companyfk')->references('id')->on('company')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedule');
    }
};
