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
        Schema::create('t_akreditasis', function (Blueprint $table) {
            $table->id('id_akreditasi');
            $table->string('judul_ppepp');
            $table->unsignedBigInteger('kriteria_id')->index();
            $table->foreign('kriteria_id')->references('kriteria_id')->on('m_kriterias');
            $table->unsignedBigInteger('penetapan_id')->index();
            $table->foreign('penetapan_id')->references('id_penetapan')->on('t_penetapans');
            $table->unsignedBigInteger('pelaksanaan_id')->index();
            $table->foreign('pelaksanaan_id')->references('id_pelaksanaan')->on('t_pelaksanaans');
            $table->unsignedBigInteger('evaluasi_id')->index();
            $table->foreign('evaluasi_id')->references('id_evaluasi')->on('t_evaluasis');
            $table->unsignedBigInteger('pengendalian_id')->index();
            $table->foreign('pengendalian_id')->references('id_pengendalian')->on('t_pengendalians');
            $table->unsignedBigInteger('peningkatan_id')->index();
            $table->foreign('peningkatan_id')->references('id_peningkatan')->on('t_peningkatans');
            $table->unsignedBigInteger('koordinator_id')->index();
            $table->foreign('koordinator_id')->references('user_id')->on('m_users');
            $table->enum('status', ['draft', 'final', 'revisi', 'selesai'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_akreditasis');
    }
};
