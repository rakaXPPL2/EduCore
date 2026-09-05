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
            $table->string('company_name')->nullable()->after('id');
            $table->string('location')->nullable()->after('company_name');
            $table->string('school_level')->default('smk')->after('location');
            $table->text('description')->nullable()->after('caption');
            $table->unsignedInteger('quota')->default(1)->after('description');
            $table->date('application_deadline')->nullable()->after('quota');
            $table->string('status')->default('published')->after('application_deadline');
            $table->index(['school_level', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loker_pkls', function (Blueprint $table) {
            $table->dropIndex(['school_level', 'status']);
            $table->dropColumn(['company_name', 'location', 'school_level', 'description', 'quota', 'application_deadline', 'status']);
        });
    }
};
