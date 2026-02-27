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
        // Hapus kolom tanggapan_admin (status enum sudah diatur di migrasi awal)
        Schema::table('aspirations', function (Blueprint $table) {
            if (Schema::hasColumn('aspirations', 'tanggapan_admin')) {
                $table->dropColumn('tanggapan_admin');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan kolom tanggapan_admin
        Schema::table('aspirations', function (Blueprint $table) {
            $table->text('tanggapan_admin')->nullable();
        });
    }
};
