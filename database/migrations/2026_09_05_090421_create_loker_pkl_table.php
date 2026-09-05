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
        Schema::create('loker_pkl', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('location');
            $table->string('address')->nullable();
            $table->string('school_level');
            $table->text('caption')->nullable();
            $table->text('description');
            $table->string('poster_path')->nullable();
            $table->integer('quota')->default(1);
            $table->date('application_deadline')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('published');
            $table->json('hasil_analisis')->nullable();
            $table->json('rekomendasi_jurusan')->nullable();
            $table->foreignId('suggested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('suggestion_status', ['direct', 'suggested', 'approved', 'rejected'])->default('direct');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loker_pkl');
    }
};
