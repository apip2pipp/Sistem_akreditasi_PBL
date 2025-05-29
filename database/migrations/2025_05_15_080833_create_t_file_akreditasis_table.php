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
            $table->string('judul_ppepp');
            $table->string('file_akreditasi');
            $table->unsignedBigInteger('akreditasi_id')->index();
            $table->foreign('akreditasi_id')->references('id_akreditasi')->on('t_akreditasis');
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
