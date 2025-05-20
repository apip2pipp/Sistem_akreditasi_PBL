<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menambahkan beberapa data contoh untuk tabel m_levels
        DB::table('m_levels')->insert([
            [
                'level_kode' => 'ADM',
                'level_nama' => 'Administrator',
            ],
            [
                'level_kode' => 'DSN',
                'level_nama' => 'Dosen',
            ],
            [
                'level_kode' => 'KDR',
                'level_nama' => 'Koordinator',
            ],
            [
                'level_kode' => 'DIR',
                'level_nama' => 'Direktur',
            ],
            [
                'level_kode' => 'KJM',
                'level_nama' => 'KJM',
            ],
            [
                'level_kode' => 'KPD',
                'level_nama' => 'Kaprodi',
            ],
            [
                'level_kode' => 'KJR',
                'level_nama' => 'Kajur',
            ],
        ]);
    }
}
