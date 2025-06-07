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
        Schema::create('t_gambar_evaluasis', function (Blueprint $table) {
            $table->id('id_gambar_evaluasi');
            $table->string('gambar_evaluasi')->nullable();
            $table->unsignedBigInteger('evaluasi_id')->index()->nullable();
            $table->foreign('evaluasi_id')->references('id_evaluasi')->on('t_evaluasis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_gambar_evaluasis');
    }
};
