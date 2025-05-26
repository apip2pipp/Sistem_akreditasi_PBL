<?php

namespace App\Http\Controllers;

use App\Models\mKoordinator;
use App\Models\mUser;
use App\Models\mLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MKoordinatorController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = mKoordinator::select('koordinator_id', 'koordinator_nama', 'koordinator_kode_tugas', 'koordinator_email');
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Koordinator',
            'list' => ['Home', 'Koordinator']
        ];

        $page = (object) [
            'title' => 'Daftar koordinator yang terdaftar dalam sistem'
        ];

        return view('koordinators.index', compact('breadcrumb', 'page'));
    }

    public function create()
    {
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('koordinators.create', compact('levels'));
    }

    public function store(Request $request)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $validator = Validator::make($request->all(), [
            'koordinator_nama' => 'required|string|max:100',
            'koordinator_kode_tugas' => 'required|string|max:100|unique:m_koordinators,koordinator_kode_tugas',
            'koordinator_email' => [
                'required',
                'email',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (DB::table('m_koordinators')->where('koordinator_email', $value)->exists()) {
                        $fail('Email sudah digunakan di tabel Koordinator.');
                    }
                    if (DB::table('m_users')->where('email', $value)->exists()) {
                        $fail('Email sudah digunakan di tabel User.');
                    }
                },
            ],
            'level_id' => 'required|exists:m_levels,level_id',
            'username' => 'required|string|unique:m_users,username|max:100',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = mUser::create([
            'username' => $request->username,
            'email' => $request->koordinator_email,
            'name' => $request->koordinator_nama,
            'level_id' => $request->level_id,
            'password' => Hash::make($request->password),
        ]);

        mKoordinator::create([
            'user_id' => $user->user_id,
            'koordinator_nama' => $request->koordinator_nama,
            'koordinator_kode_tugas' => $request->koordinator_kode_tugas,
            'koordinator_email' => $request->koordinator_email,
        ]);

        return response()->json([
            'message' => 'Data koordinator berhasil disimpan'
        ], Response::HTTP_OK);
    }

    public function edit($id)
    {
        $mKoordinator = mKoordinator::with('user')->find($id);
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('koordinators.edit', compact('mKoordinator', 'levels'));
    }

    public function update(Request $request, $id)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $mKoordinator = mKoordinator::with('user')->find($id);
        if (!$mKoordinator) {
            return response()->json([
                'message' => 'Data koordinator tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'koordinator_nama' => 'required|string|max:100',
            'koordinator_kode_tugas' => 'required|string|max:100|unique:m_koordinators,koordinator_kode_tugas,' . $id . ',koordinator_id',
            'koordinator_email' => [
                'required',
                'email',
                'max:100',
                function ($attribute, $value, $fail) use ($id, $mKoordinator) {
                    if (
                        DB::table('m_koordinators')
                        ->where('koordinator_email', $value)
                        ->where('koordinator_id', '!=', $id)
                        ->exists()
                    ) {
                        $fail('Email sudah digunakan di tabel Koordinator.');
                    }

                    if (
                        DB::table('m_users')
                        ->where('email', $value)
                        ->where('user_id', '!=', $mKoordinator->user_id)
                        ->exists()
                    ) {
                        $fail('Email sudah digunakan di tabel User.');
                    }
                }
            ],
            'level_id' => 'required|exists:m_levels,level_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $username = $request->koordinator_kode_tugas;

        $mKoordinator->update([
            'koordinator_nama' => $request->koordinator_nama,
            'koordinator_kode_tugas' => $request->koordinator_kode_tugas,
            'koordinator_email' => $request->koordinator_email,
        ]);

        if ($mKoordinator->user) {
            $mKoordinator->user->update([
                'username' => $username,
                'email' => $request->koordinator_email,
                'name' => $request->koordinator_nama,
                'level_id' => $request->level_id,
                'password' => Hash::make($username),
            ]);
        }

        return response()->json([
            'message' => 'Data koordinator berhasil diperbarui'
        ], Response::HTTP_OK);
    }

    public function confirm(string $id)
    {
        $mKoordinator = mKoordinator::with('user')->find($id);
        return view('koordinators.confirm-delete', compact('mKoordinator'));
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mKoordinator = mKoordinator::find($id);
            if (!$mKoordinator) {
                return response()->json([
                    'message' => 'Data koordinator tidak ditemukan'
                ], Response::HTTP_NOT_FOUND);
            }

            $user = $mKoordinator->user;
            if ($user) {
                $mKoordinator->delete();
                $user->delete();
            }

            return response()->json([
                'message' => 'Data koordinator dan user berhasil dihapus!'
            ], Response::HTTP_OK);
        }

        return redirect('/dashboard');
    }
}
