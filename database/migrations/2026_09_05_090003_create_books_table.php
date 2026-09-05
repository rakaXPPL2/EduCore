<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table): void {
            $table->id();
            $table->string('book_code')->unique();
            $table->string('isbn')->nullable()->index();
            $table->string('title')->index();
            $table->string('author');
            $table->string('publisher');
            $table->unsignedSmallInteger('publish_year');
            $table->string('ddc_code')->nullable();
            $table->string('rack_location');
            $table->unsignedInteger('total_stock')->default(1);
            $table->unsignedInteger('available_stock')->default(1);
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->text('synopsis')->nullable();
            $table->string('cover_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
