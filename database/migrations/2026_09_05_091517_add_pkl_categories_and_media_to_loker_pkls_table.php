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
        Schema::table('loker_pkls', function (Blueprint $table) {
            $table->string('address')->nullable()->after('location');
            $table->string('poster_path')->nullable()->after('description');
            $table->foreignId('suggested_by')->nullable()->after('rekomendasi_jurusan')->constrained('users')->nullOnDelete();
            $table->string('suggestion_status')->default('direct')->after('suggested_by');
            $table->boolean('is_featured')->default(false)->after('suggestion_status');
            $table->string('major')->nullable()->after('school_level');
            $table->string('class_level')->nullable()->after('major');
            $table->string('class_number')->nullable()->after('class_level');
            $table->index(['school_level', 'class_level', 'class_number']);
            $table->index(['major', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loker_pkls', function (Blueprint $table) {
            $table->dropIndex(['school_level', 'class_level', 'class_number']);
            $table->dropIndex(['major', 'status']);
            $table->dropConstrainedForeignId('suggested_by');
            $table->dropColumn(['address', 'poster_path', 'suggestion_status', 'is_featured', 'major', 'class_level', 'class_number']);
        });
    }
};
