<?php

namespace App\Http\Controllers;

use App\Models\tPermissionKriteriaUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Models\mKriteria;
use App\Models\mKoordinator;
use App\Models\mLevel;
use App\Models\mUser;
use Illuminate\Support\Facades\Log;

class TPermissionKriteriaUserController extends Controller
{
    public function list(Request $request)
    {
        if (!$request->ajax()) {
            abort(403);
        }

        $users = mUser::with(['permissions.kriteria', 'level'])
            ->whereHas('level', function ($query) {
                $query->where('level_kode', 'KDR')
                    ->orWhere('level_nama', 'Koordinator');
            })
            ->select('user_id', 'name')
            ->get();


        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('hak_permission', function ($koordinator) {
                // Ambil permission kriteria yang statusnya aktif
                $aktifPermissions = $koordinator->permissions->filter(fn($p) => $p->status);
                // Ambil nama kriteria
                $listKriteria = $aktifPermissions->pluck('kriteria.nama_kriteria')->toArray();

                return count($listKriteria) ? implode(', ', $listKriteria) : '-';
            })
            ->make(true);
    }


    /**
     * Tampilkan halaman manage permission untuk koordinator tertentu
     */
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Permission List Criteria',
            'list' => ['Home', 'Permission Kriteria',]
        ];

        $page = (object)[
            'title' => 'Permission List Criteria'
        ];
        return view('permission_kriteria.index', compact('breadcrumb', 'page'));
    }

    public function edit($id)
    {
        $koordinator = mUser::with('level')
            ->whereHas('level', function ($query) {
                $query->where('level_kode', 'KDR')
                    ->orWhere('level_nama', 'Koordinator');
            })
            ->findOrFail($id);
        $kriteria = mKriteria::all();
        return view('permission_kriteria.edit', compact('koordinator', 'kriteria'));
    }

    public function update(Request $request, $id)
    {
        $koordinator = mUser::with('level')
            ->whereHas('level', function ($query) {
                $query->where('level_kode', 'KDR')
                    ->orWhere('level_nama', 'Koordinator');
            })
            ->findOrFail($id);
        $kriteriaIds = array_filter($request->input('kriteria', [])); // hanya yg dicentang

        Log::debug('Update Permission Request Data', [
            'user_id' => $id,
            'input_kriteria' => $request->input('kriteria'),
            'filtered_kriteriaIds' => $kriteriaIds
        ]);

        DB::beginTransaction();
        try {
            // Hapus semua yang tidak dicentang
            $deleted = tPermissionKriteriaUser::where('user_id', $id)
                ->whereNotIn('kriteria_id', $kriteriaIds)
                ->delete();

            Log::debug('Permissions deleted (non-selected)', [
                'deleted_count' => $deleted
            ]);

            // Tambahkan atau update yang dicentang
            foreach ($kriteriaIds as $kriteriaId) {
                $permission = tPermissionKriteriaUser::updateOrCreate(
                    [
                        'user_id' => $id,
                        'kriteria_id' => $kriteriaId,
                    ],
                    [
                        'status' => true,
                    ]
                );
                Log::debug('Permission upserted', [
                    'user_id' => $id,
                    'kriteria_id' => $kriteriaId,
                    'model_id' => $permission->id_permission_kriteria_user ?? null
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Permission successfully updated']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
