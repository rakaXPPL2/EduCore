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
        Schema::create('permit_requests', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('type');
            $table->date('permit_date');
            $table->text('description');
            $table->string('attachment_path')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->index(['student_name', 'permit_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permit_requests');
    }
};
