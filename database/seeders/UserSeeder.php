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
            [
                'level_id' => 2,
                'username' => 'johndoe',
                'email' => 'johndoe@gmail.com',
                'name' => 'John Doe',
                'password' => Hash::make('12345678'),
            ],
            [
                'level_id' => 2,
                'username' => 'jane_smith',
                'email' => 'jane_smith@gmail.com',
                'name' => 'Jane Smith',
                'password' => Hash::make('12345678'),
            ],
            [
                'level_id' => 3,
                'username' => 'koordinator',
                'email' => 'koordinator@gmail.com',
                'name' => 'Koordinator One',
                'password' => Hash::make('12345678'),
            ],
            [
                'level_id' => 3,
                'username' => 'koordinator2',
                'email' => 'koordinator2@gmail.com',
                'name' => 'Koordinator Two',
                'password' => Hash::make('12345678'),
            ],
            [
                'level_id' => 4,
                'username' => 'Direktur',
                'email' => 'Direktur@gmail.com',
                'name' => 'Direktur One',
                'password' => Hash::make('12345678'),
            ],
            [
                'level_id' => 4,
                'username' => 'Direktur2',
                'email' => 'Direktur2@gmail.com',
                'name' => 'Direktur Two',
                'password' => Hash::make('12345678'),
            ],
            [
                'level_id' => 5,
                'username' => 'KJM',
                'email' => 'KJM@gmail.com',
                'name' => 'KJM One',
                'password' => Hash::make('12345678'),
            ],
            [
                'level_id' => 5,
                'username' => 'KJM2',
                'email' => 'KJM2@gmail.com',
                'name' => 'KJM Two',
                'password' => Hash::make('12345678'),
            ],
            [
                'level_id' => 6,
                'username' => 'KPD',
                'email' => 'KPD@gmail.com',
                'name' => 'KPD One',
                'password' => Hash::make('12345678'),
            ],
            [
                'level_id' => 6,
                'username' => 'KPD2',
                'email' => 'KPD2@gmail.com',
                'name' => 'KPD Two',
                'password' => Hash::make('12345678'),
            ],
            [
                'level_id' => 7,
                'username' => 'KJ',
                'email' => 'KJ@gmail.com',
                'name' => 'KJ One',
                'password' => Hash::make('12345678'),
            ],
            [
                'level_id' => 7,
                'username' => 'KJ2',
                'email' => 'KJ2@gmail.com',
                'name' => 'KJ Two',
                'password' => Hash::make('12345678'),
            ],
        ]);

        //m_koordinators
        DB::table('m_koordinators')->insert([
            [
                'user_id' => 4,
                'koordinator_nama' => 'Koordinator One',
                'koordinator_kode_tugas' => '19012912312121',
                'koordinator_email' => 'koordinator1@gmail.com',
            ],
            [
                'user_id' => 5,
                'koordinator_nama' => 'Koordinator Two',
                'koordinator_kode_tugas' => '19012912312122',
                'koordinator_email' => 'koordinator2@gmail.com',
            ],
        ]);

        //m_dosens
        DB::table('m_dosens')->insert([
            [
                'user_id' => 2,
                'dosen_nip' => '19012912312121',
                'dosen_nidn' => '19012912312121',
                'dosen_nama' => 'Dosen One',
                'dosen_email' => 'dosen1@gmail.com',
                'dosen_gender' => 'L',
            ],
            [
                'user_id' => 3,
                'dosen_nip' => '19012912312122',
                'dosen_nidn' => '19012912312122',
                'dosen_nama' => 'Dosen Two',
                'dosen_email' => 'dosen2@gmail.com',
                'dosen_gender' => 'L',
            ],
        ]);

        //mdirektur
        DB::table('m_diruts')->insert([
            [
                'user_id' => 6,
                'dirut_nama' => 'Direktur One',
                'dirut_nip' => '19012912312121',
                'dirut_email' => 'direktur1@gmail.com',
            ],
            [
                'user_id' => 7,
                'dirut_nama' => 'Direktur Two',
                'dirut_nip' => '19012912312122',
                'dirut_email' => 'direktur2@gmail.com',
            ],
        ]);

        //m_kjm
        DB::table('m_kjms')->insert([
            [
                'user_id' => 8,
                'kjm_nama' => 'KJM One',
                'no_pegawai' => '19012912312121',
                'kjm_email' => 'kjm1@gmail.com',
            ],
            [
                'user_id' => 9,
                'kjm_nama' => 'KJM Two',
                'no_pegawai' => '19012912312122',
                'kjm_email' => 'kjm2@gmail.com',
            ],
        ]);

        //m_kaprodis
        DB::table('m_kaprodis')->insert([
            [
                'user_id' => 10,
                'kaprodi_nama' => 'Kaprodi One',
                'kaprodi_nidn' => '1901291231311',
                'kaprodi_nip' => '19012912312121',
                'kaprodi_gender' => 'L',
                'kaprodi_prodi' => 'D-IV Teknik Informatika',
                'kaprodi_email' => 'kaprodi1@gmail.com',
            ],
            [
                'user_id' => 11,
                'kaprodi_nama' => 'Kaprodi Two',
                'kaprodi_nidn' => '19012912312121',
                'kaprodi_nip' => '190129123121231',
                'kaprodi_gender' => 'L',
                'kaprodi_prodi' => 'D-IV Teknik Informatika',
                'kaprodi_email' => 'kaprodi2@gmail.com',
            ],
        ]);

        //m_kajur
        DB::table('m_kajurs')->insert([
            [
                'user_id' => 12,
                'kajur_nama' => 'Kajur One',
                'kajur_nip' => '19012912312121',
                'kajur_nidn' => '19012912312121',
                'kajur_email' => 'kajur1@gmail.com',
            ],
            [
                'user_id' => 13,
                'kajur_nama' => 'Kajur Two',
                'kajur_nip' => '19012912312122',
                'kajur_nidn' => '19012912312122',
                'kajur_email' => 'kajur2@gmail.com',
            ],
        ]);
    }
}
