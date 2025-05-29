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
        Schema::create('t_permission_kriteria_users', function (Blueprint $table) {
            $table->id('id_permission_kriteria_user');
            $table->unsignedBigInteger('kriteria_id')->index();
            $table->foreign('kriteria_id')->references('kriteria_id')->on('m_kriterias');
            $table->unsignedBigInteger('koordinator_id')->index();
            $table->foreign('koordinator_id')->references('koordinator_id')->on('m_koordinators');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_permission_kriteria_users');
    }
};
