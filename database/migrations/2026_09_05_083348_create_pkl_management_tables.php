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
        Schema::create('pkl_settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_level')->default('smk');
            $table->boolean('pkl_enabled')->default(true);
            $table->string('period')->nullable();
            $table->date('defense_start_date')->nullable();
            $table->timestamps();
        });

        Schema::create('pkl_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('loker_pkl_id')->constrained()->cascadeOnDelete();
            $table->text('motivation')->nullable();
            $table->string('status')->default('pending');
            $table->text('admin_note')->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'loker_pkl_id']);
            $table->index('status');
        });

        Schema::create('pkl_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pkl_application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('report_path');
            $table->string('status')->default('pending');
            $table->text('feedback')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            $table->index('status');
        });

        Schema::create('pkl_defenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pkl_report_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->dateTime('scheduled_at');
            $table->string('room')->nullable();
            $table->string('examiner')->nullable();
            $table->string('status')->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkl_defenses');
        Schema::dropIfExists('pkl_reports');
        Schema::dropIfExists('pkl_applications');
        Schema::dropIfExists('pkl_settings');
    }
};
