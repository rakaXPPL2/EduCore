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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subject');
            $table->string('teacher')->nullable();
            $table->text('description')->nullable();
            $table->dateTime('due_at');
            $table->unsignedInteger('max_points')->default(100);
            $table->string('status')->default('pending');
            $table->dateTime('submitted_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'due_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
