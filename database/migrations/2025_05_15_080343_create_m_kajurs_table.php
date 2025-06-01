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
        Schema::create('m_kajurs', function (Blueprint $table) {
            $table->id('kajur_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('user_id')->on('m_users');
            $table->string('kajur_nama', 100);
            $table->string('kajur_nidn')->nullable()->unique();
            $table->string('kajur_nip')->nullable()->unique();
            $table->string('kajur_email')->nullable()->unique();
            $table->enum('kajur_gender', ['L', 'P']);
            $table->enum('kajur_jurusan', ['Jurusan Teknologi Informasi']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_kajurs');
    }
};
