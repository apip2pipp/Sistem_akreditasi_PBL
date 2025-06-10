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
        Schema::create('t_penelitian_dosens', function (Blueprint $table) {
            $table->id('id_penelitian_dosen');
            $table->unsignedBigInteger('user_id')->index();
            $table->foreign('user_id')->references('user_id')->on('m_users');
            $table->unsignedBigInteger('penelitian_id')->index();
            $table->foreign('penelitian_id')->references('id_penelitian')->on('m_penelitian_dosens');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_penelitian_dosens');
    }
};
