<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menambahkan beberapa data contoh untuk tabel m_users
        DB::table('m_users')->insert([
            [
                'level_id' => 1, // Pastikan ini sesuai dengan level_id yang ada di m_levels
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'name' => 'Admin User',
                'password' => Hash::make('12345678'), // Password yang sudah di-hash
            ],
        ]);

    }
}
