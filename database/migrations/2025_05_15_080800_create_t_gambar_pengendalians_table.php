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
        Schema::create('t_gambar_pengendalians', function (Blueprint $table) {
            $table->id('id_gambar_pengendalian');
            $table->string('gambar_pengendalian')->nullable();
            $table->unsignedBigInteger('pengendalian_id')->index()->nullable();
            $table->foreign('pengendalian_id')->references('id_pengendalian')->on('t_pengendalians');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_gambar_pengendalians');
    }
};
