<?php

namespace App\Imports;

use App\Models\mDosen;
use App\Models\mUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;

class DosenImport implements ToModel, WithHeadingRow
{
    protected $level_id;
    protected $failedRows = [];

    public function __construct($level_id)
    {
        $this->level_id = $level_id;
    }

    public function model(array $row)
    {
        // Cek apakah NIP atau email sudah ada di database (baik di mDosen maupun mUser)
        if (
            mDosen::where('dosen_nip', $row['nip'])->exists() ||
            mDosen::where('dosen_email', $row['email'])->exists() ||
            mUser::where('username', $row['nip'])->exists() ||
            mUser::where('email', $row['email'])->exists()
        ) {
            // Menambahkan ke daftar gagal jika data duplikat ditemukan
            $this->failedRows[] = $row;
            return null; // Skip this row
        }

        // Tentukan username dan password
        $username = !empty($row['nip']) ? $row['nip'] : $row['nidn'];
        $password = !empty($row['nip']) ? $row['nip'] : $row['nidn'];

        // Jika keduanya kosong, skip baris tersebut
        if (empty($username) || empty($password)) {
            $this->failedRows[] = $row;
            return null; // Skip this row
        }

        // Buat user
        try {
            $user = mUser::create([
                'username' => $username,
                'email' => $row['email'],
                'name' => $row['nama'],
                'password' => Hash::make($password), // Password di-hash menggunakan NIP atau NIDN
                'level_id' => $this->level_id
            ]);

            // Simpan data dosen
            mDosen::create([
                'dosen_nip' => $row['nip'],
                'dosen_nama' => $row['nama'],
                'dosen_nidn' => $row['nidn'],
                'dosen_email' => $row['email'],
                'dosen_gender' => $row['gender'], // 'L' atau 'P'
                'user_id' => $user->user_id
            ]);
        } catch (\Exception $e) {
            // Tangani kesalahan lain (misalnya kesalahan saat menyimpan)
            $this->failedRows[] = $row; // Menambahkan ke daftar gagal
            Log::error('Error saat mengimport data dosen: ' . $e->getMessage());
        }

        return null;
    }

    // Menambahkan metode untuk mendapatkan jumlah kegagalan
    public function getFailedRows()
    {
        return $this->failedRows;
    }
}
