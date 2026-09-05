<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('nis_nip')->nullable()->unique()->after('email');
            $table->string('class_major')->nullable()->after('student_class');
            $table->string('phone_number')->nullable()->after('class_major');
            $table->string('avatar')->nullable()->after('phone_number');
            $table->uuid('qr_code_token')->nullable()->unique()->after('avatar');
            $table->unsignedInteger('literacy_points')->default(0)->after('qr_code_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropUnique(['nis_nip']);
            $table->dropUnique(['qr_code_token']);
            $table->dropColumn(['nis_nip', 'class_major', 'phone_number', 'avatar', 'qr_code_token', 'literacy_points']);
        });
    }
};
