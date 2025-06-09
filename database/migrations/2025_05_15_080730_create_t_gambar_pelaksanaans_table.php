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
        Schema::create('t_gambar_pelaksanaans', function (Blueprint $table) {
            $table->id('id_gambar_pelaksanaan');
            $table->string('gambar_pelaksanaan')->nullable();
            $table->unsignedBigInteger('pelaksanaan_id')->index()->nullable();
            $table->foreign('pelaksanaan_id')->references('id_pelaksanaan')->on('t_pelaksanaans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_gambar_pelaksanaans');
    }
};
