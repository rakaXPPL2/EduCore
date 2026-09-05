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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('teacher')->nullable();
            $table->string('room')->nullable();
            $table->string('day_of_week');
            $table->date('schedule_date');
            $table->time('starts_at');
            $table->time('ends_at');
            $table->timestamps();

            $table->index(['schedule_date', 'starts_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
