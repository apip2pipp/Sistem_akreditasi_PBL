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
        Schema::create('t_gambar_penetapans', function (Blueprint $table) {
            $table->id('id_gambar_penetapan');
            $table->string('gambar_penetapan')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('penetapan_id')->index()->nullable();
            $table->foreign('penetapan_id')->references('id_penetapan')->on('t_penetapans');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_gambar_penetapans');
    }
};
