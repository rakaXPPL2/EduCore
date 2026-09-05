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
        Schema::table('assignments', function (Blueprint $table) {
            $table->foreignId('school_class_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('file_path')->nullable();
            $table->string('resource_link')->nullable();
            $table->index(['school_class_id', 'subject_id', 'due_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropIndex(['school_class_id', 'subject_id', 'due_at']);
            $table->dropConstrainedForeignId('school_class_id');
            $table->dropConstrainedForeignId('subject_id');
            $table->dropConstrainedForeignId('teacher_id');
            $table->dropColumn(['file_path', 'resource_link']);
        });
    }
};
