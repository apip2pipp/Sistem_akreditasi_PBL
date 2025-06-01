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
        Schema::create('m_dosens', function (Blueprint $table) {
            $table->id('dosen_id');
            $table->string('dosen_nip')->nullable()->unique();
            $table->string('dosen_nidn')->nullable()->unique();
            $table->string('dosen_nama', 100);
            $table->string('dosen_email', 50)->unique();
            $table->enum('dosen_gender', ['L', 'P']);
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('user_id')->on('m_users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_dosens');
    }
};
