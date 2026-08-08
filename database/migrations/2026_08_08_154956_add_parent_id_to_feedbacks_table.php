<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            // F-13: Self-referential untuk reply feedback (siswa bisa membalas)
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
            $table->foreign('parent_id')->references('id')->on('feedbacks')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }
};

