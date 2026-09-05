<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table): void {
            $table->string('edition')->nullable()->after('publish_year');
            $table->string('language', 50)->default('Bahasa Indonesia')->after('edition');
            $table->unsignedSmallInteger('page_count')->nullable()->after('language');
            $table->string('book_format', 50)->default('Buku cetak')->after('page_count');
            $table->string('reading_level', 80)->nullable()->after('book_format');
            $table->string('keywords')->nullable()->after('synopsis');
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table): void {
            $table->dropColumn(['edition', 'language', 'page_count', 'book_format', 'reading_level', 'keywords']);
        });
    }
};
