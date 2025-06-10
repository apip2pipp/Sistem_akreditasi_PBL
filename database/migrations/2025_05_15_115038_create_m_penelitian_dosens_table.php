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
        Schema::create('m_penelitian_dosens', function (Blueprint $table) {
            $table->id('id_penelitian');
            $table->string('no_surat_tugas');
            $table->string('judul_penelitian');
            $table->string('pendanaan_internal')->nullable();
            $table->string('pendanaan_eksternal')->nullable();
            $table->string('link_penelitian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_penelitian_dosens');
    }
};
