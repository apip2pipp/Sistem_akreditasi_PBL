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
        Schema::create('t_gambar_peningkatans', function (Blueprint $table) {
            $table->id('id_gambar_peningkatan');
            $table->string('gambar_peningkatan')->nullable();
            $table->unsignedBigInteger('peningkatan_id')->index()->nullable();
            $table->foreign('peningkatan_id')->references('id_peningkatan')->on('t_peningkatans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_gambar_peningkatans');
    }
};
