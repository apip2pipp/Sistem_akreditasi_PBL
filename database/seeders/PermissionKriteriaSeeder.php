<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Koordinator 1 -> Kriteria 1-4
        foreach (range(1, 4) as $kriteriaId) {
            DB::table('t_permission_kriteria_users')->insert([
                'koordinator_id'     => 1,
                'status'      => true,
                'kriteria_id' => $kriteriaId,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }

        // Koordinator 2 -> Kriteria 5-9
        foreach (range(5, 9) as $kriteriaId) {
            DB::table('t_permission_kriteria_users')->insert([
                'koordinator_id'     => 2,
                'status'      => true,
                'kriteria_id' => $kriteriaId,
                'created_at'  => $now,
                'updated_at'  => $now,
            ]);
        }
    }
}
