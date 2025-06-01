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
        Schema::create('m_kaprodis', function (Blueprint $table) {
            $table->id('kaprodi_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('user_id')->on('m_users');
            $table->string('kaprodi_nama', 100);
            $table->string('kaprodi_nidn')->nullable()->unique();
            $table->string('kaprodi_nip')->nullable()->unique();
            $table->string('kaprodi_email')->nullable()->unique();
            $table->enum('kaprodi_gender', ['L', 'P']);
            $table->enum('kaprodi_prodi', ['D-IV Teknik Informatika', 'D-IV Sistem Informasi Bisnis', 'D-II Pengembangan Perangkat Lunak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kaprodis');
    }
};
