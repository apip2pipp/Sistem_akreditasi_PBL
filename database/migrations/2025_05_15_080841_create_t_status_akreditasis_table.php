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
        Schema::create('t_status_akreditasis', function (Blueprint $table) {
            $table->id('id_status_akreditasi');
            $table->unsignedBigInteger('file_akreditasi_id')->index();
            $table->foreign('file_akreditasi_id')->references('id_file_akreditasi')->on('t_file_akreditasis');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_status_akreditasis');
    }
};
