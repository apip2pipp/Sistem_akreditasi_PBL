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
        Schema::create('t_file_akreditasis', function (Blueprint $table) {
            $table->id('id_file_akreditasi');
            $table->string('file_akreditasi')->nullable();
            $table->unsignedBigInteger('akreditasi_id')->index();
            $table->foreign('akreditasi_id')->references('id_akreditasi')->on('t_akreditasis');
            // Kaprodi
            $table->enum('status_kaprodi', ['Pending', 'Disetujui', 'Ditolak'])->nullable()->default('Pending');
            $table->text('komentar_kaprodi')->nullable();
            $table->unsignedBigInteger('kaprodi_id')->nullable()->index();
            $table->foreign('kaprodi_id')->references('user_id')->on('m_users');
            $table->dateTime('tanggal_waktu_kaprodi')->nullable();

            // Kajur
            $table->enum('status_kajur', ['Pending', 'Disetujui', 'Ditolak'])->nullable()->default('Pending');
            $table->text('komentar_kajur')->nullable();
            $table->unsignedBigInteger('kajur_id')->nullable()->index();
            $table->foreign('kajur_id')->references('user_id')->on('m_users');
            $table->dateTime('tanggal_waktu_kajur')->nullable();

            // KJM
            $table->enum('status_kjm', ['Pending', 'Disetujui', 'Ditolak'])->nullable()->default('Pending');
            $table->text('komentar_kjm')->nullable();
            $table->unsignedBigInteger('kjm_id')->nullable()->index();
            $table->foreign('kjm_id')->references('user_id')->on('m_users');
            $table->dateTime('tanggal_waktu_kjm')->nullable();

            // Direktur Utama
            $table->enum('status_direktur_utama', ['Pending', 'Disetujui', 'Ditolak'])->nullable()->default('Pending');
            $table->text('komentar_direktur_utama')->nullable();
            $table->unsignedBigInteger('direktur_utama_id')->nullable()->index();
            $table->foreign('direktur_utama_id')->references('user_id')->on('m_users');
            $table->dateTime('tanggal_waktu_direktur_utama')->nullable();

            // colom status file
            $table->enum('statusFile', ['Draft', 'Final', 'Revisi', 'Validation'])->nullable()->default('Draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_file_akreditasis');
    }
};
