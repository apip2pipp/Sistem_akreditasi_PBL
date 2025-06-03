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
        Schema::create('m_users', function (Blueprint $table) {
            $table->id('user_id');
            $table->string('username', 100)->unique();
            $table->string('email', 100)->unique();
            $table->string('name', 100);
            $table->string('NIDN', 100)->nullable();
            $table->string('password');
            $table->unsignedBigInteger('level_id')->index();
            $table->foreign('level_id')->references('level_id')->on('m_levels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_users');
    }
};
