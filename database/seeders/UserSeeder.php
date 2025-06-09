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
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'name' => 'Admin User',
                'password' => Hash::make('12345678'),
                'level_id' => 1, // Administrator
            ],
            [
                'username' => 'dosen',
                'email' => 'johndoe@gmail.com',
                'name' => 'John Doe',
                'password' => Hash::make('12345678'),
                'level_id' => 2, // Dosen
            ],
            [
                'username' => 'dosen2',
                'email' => 'jane_smith@gmail.com',
                'name' => 'Jane Smith',
                'password' => Hash::make('12345678'),
                'level_id' => 2, // Dosen
            ],
            [
                'username' => 'koordinator',
                'email' => 'Smith Calorine@gmail.com',
                'name' => 'Smith Calorine',
                'password' => Hash::make('12345678'),
                'level_id' => 3, // Koordinator
            ],
            [
                'username' => 'koordinator2',
                'email' => 'franklin@gmail.com',
                'name' => 'Franklint Tim',
                'password' => Hash::make('12345678'),
                'level_id' => 3, // Koordinator
            ],
            [
                'username' => 'direktur',
                'email' => 'jackson@gmail.com',
                'name' => 'Jackson Tim',
                'password' => Hash::make('12345678'),
                'level_id' => 4, // Direktur
            ],
            [
                'username' => 'kjm',
                'email' => 'caroll@gmail.com',
                'name' => 'Caroll Martin',
                'password' => Hash::make('12345678'),
                'level_id' => 5, // KJM
            ],
            [
                'username' => 'kaprodi',
                'email' => 'klusevky@gmail.com',
                'name' => 'Klusevky',
                'password' => Hash::make('12345678'),
                'level_id' => 6, // Kaprodi
            ],
            [
                'username' => 'kajur',
                'email' => 'kylian@gmail.com',
                'name' => 'Kylian',
                'password' => Hash::make('12345678'),
                'level_id' => 7, // Kajur
            ],
        ]);
    }
}
