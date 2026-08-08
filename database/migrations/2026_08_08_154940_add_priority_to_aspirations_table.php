<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('aspirations', function (Blueprint $table) {
            // F-08: Label prioritas aspirasi
            $table->enum('priority', ['rendah', 'sedang', 'tinggi', 'mendesak'])
                  ->default('sedang')
                  ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('aspirations', function (Blueprint $table) {
            $table->dropColumn('priority');
        });
    }
};

