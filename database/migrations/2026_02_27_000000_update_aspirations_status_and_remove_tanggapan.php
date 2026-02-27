<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tambah nilai 'diajukan' ke enum status dan jadikan default
        DB::statement("ALTER TABLE aspirations MODIFY status ENUM('diajukan', 'diproses', 'selesai', 'ditolak') NOT NULL DEFAULT 'diajukan'");

        // Hapus kolom tanggapan_admin
        Schema::table('aspirations', function (Blueprint $table) {
            $table->dropColumn('tanggapan_admin');
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

        // Kembalikan enum status ke semula
        DB::statement("ALTER TABLE aspirations MODIFY status ENUM('diproses', 'selesai', 'ditolak') NOT NULL DEFAULT 'diproses'");
    }
};
