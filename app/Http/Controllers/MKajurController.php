<?php

namespace App\Http\Controllers;

use App\Models\mKajur;
use App\Models\mUser;
use App\Models\mLevel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MKajurController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = mKajur::select('kajur_id', 'kajur_nama', 'kajur_nip', 'kajur_email');
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Kajur',
            'list' => ['Home', 'Kajur']
        ];

        $page = (object)[
            'title' => 'Daftar Ketua Jurusan dalam sistem'
        ];

        return view('kajurs.index', compact('breadcrumb', 'page'));
    }

    public function create()
    {
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('kajurs.create', compact('levels'));
    }

    public function store(Request $request)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $validator = Validator::make($request->all(), [
            'kajur_nama' => 'required|string|max:100',
            'kajur_nip' => 'nullable|string|unique:m_kajurs,kajur_nip',
            'kajur_nidn' => 'nullable|string|unique:m_kajurs,kajur_nidn',
            'kajur_email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (DB::table('m_kajurs')->where('kajur_email', $value)->exists()) {
                        $fail('Email sudah digunakan di tabel Kajur.');
                    }
                    if (DB::table('m_users')->where('email', $value)->exists()) {
                        $fail('Email sudah digunakan di tabel User.');
                    }
                },
            ],
            'kajur_gender' => 'required|in:L,P',
            'kajur_jurusan' => 'required|in:Jurusan Teknologi Informasi',
            'level_id' => 'required|exists:m_levels,level_id',
            'username' => 'required|string|unique:m_users,username',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = mUser::create([
            'username' => $request->username,
            'email' => $request->kajur_email,
            'name' => $request->kajur_nama,
            'level_id' => $request->level_id,
            'password' => Hash::make($request->password),
        ]);

        mKajur::create([
            'user_id' => $user->user_id,
            'kajur_nama' => $request->kajur_nama,
            'kajur_nip' => $request->kajur_nip,
            'kajur_nidn' => $request->kajur_nidn,
            'kajur_email' => $request->kajur_email,
            'kajur_gender' => $request->kajur_gender,
            'kajur_jurusan' => $request->kajur_jurusan,
        ]);

        return response()->json([
            'message' => 'Data Kajur berhasil disimpan'
        ], Response::HTTP_OK);
    }

    public function edit($id)
    {
        $mKajur = mKajur::with('user')->find($id);
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('kajurs.edit', compact('mKajur', 'levels'));
    }

    public function update(Request $request, $id)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $mKajur = mKajur::with('user')->find($id);
        if (!$mKajur) {
            return response()->json([
                'message' => 'Data Kajur tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'kajur_nama' => 'required|string|max:100',
            'kajur_nip' => 'nullable|string|unique:m_kajurs,kajur_nip,' . $id . ',kajur_id',
            'kajur_nidn' => 'nullable|string|unique:m_kajurs,kajur_nidn,' . $id . ',kajur_id',
            'kajur_email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($id, $mKajur) {
                    if (
                        DB::table('m_kajurs')
                        ->where('kajur_email', $value)
                        ->where('kajur_id', '!=', $id)
                        ->exists()
                    ) {
                        $fail('Email sudah digunakan di tabel Kajur.');
                    }

                    if (
                        DB::table('m_users')
                        ->where('email', $value)
                        ->where('user_id', '!=', $mKajur->user_id)
                        ->exists()
                    ) {
                        $fail('Email sudah digunakan di tabel User.');
                    }
                }
            ],
            'kajur_gender' => 'required|in:L,P',
            'kajur_jurusan' => 'required|in:Jurusan Teknologi Informasi',
            'level_id' => 'required|exists:m_levels,level_id',
            'username' => 'required|string|unique:m_users,username,' . $mKajur->user_id . ',user_id',
            'password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $username = $request->kajur_nip ?: $request->kajur_email;

        $mKajur->update([
            'kajur_nama' => $request->kajur_nama,
            'kajur_nip' => $request->kajur_nip,
            'kajur_nidn' => $request->kajur_nidn,
            'kajur_email' => $request->kajur_email,
            'kajur_gender' => $request->kajur_gender,
            'kajur_jurusan' => $request->kajur_jurusan,
        ]);

        if ($mKajur->user) {
            $mKajur->user->update([
                'username' => $request->username,
                'email' => $request->kajur_email,
                'name' => $request->kajur_nama,
                'level_id' => $request->level_id,
                'password' => Hash::make($request->password), // opsional
            ]);
        }

        return response()->json([
            'message' => 'Data Kajur berhasil diperbarui'
        ], Response::HTTP_OK);
    }

    public function confirm(string $id)
    {
        $mKajur = mKajur::with('user')->find($id);
        return view('kajurs.confirm-delete', compact('mKajur'));
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mKajur = mKajur::find($id);
            if (!$mKajur) {
                return response()->json([
                    'message' => 'Data Kajur tidak ditemukan'
                ], Response::HTTP_NOT_FOUND);
            }

            $user = $mKajur->user;
            if ($user) {
                $mKajur->delete();
                $user->delete();
            }

            return response()->json([
                'message' => 'Data Kajur dan user berhasil dihapus!'
            ], Response::HTTP_OK);
        }

        return redirect('/dashboard');
    }
}
