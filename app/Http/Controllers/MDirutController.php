<?php

namespace App\Http\Controllers;

use App\Models\mDirut;
use App\Models\mUser;
use App\Models\mLevel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MDirutController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = mDirut::select('dirut_id', 'dirut_nama', 'dirut_nip', 'dirut_email');
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Dirut',
            'list' => ['Home', 'Dirut']
        ];

        $page = (object)[
            'title' => 'Daftar dirut yang terdaftar dalam sistem'
        ];

        return view('diruts.index', compact('breadcrumb', 'page'));
    }

    public function create()
    {
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('diruts.create', compact('levels'));
    }

    public function store(Request $request)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $validator = Validator::make($request->all(), [
            'dirut_nama' => 'required|string|max:100',
            'dirut_nip' => 'required|string|unique:m_diruts,dirut_nip',
            'dirut_email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (DB::table('m_diruts')->where('dirut_email', $value)->exists()) {
                        $fail('Email sudah digunakan di tabel Dirut.');
                    }
                    if (DB::table('m_users')->where('email', $value)->exists()) {
                        $fail('Email sudah digunakan di tabel User.');
                    }
                },
            ],
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
            'email' => $request->dirut_email,
            'name' => $request->dirut_nama,
            'level_id' => $request->level_id,
            'password' => Hash::make($request->password),
        ]);

        mDirut::create([
            'user_id' => $user->user_id,
            'dirut_nama' => $request->dirut_nama,
            'dirut_nip' => $request->dirut_nip,
            'dirut_email' => $request->dirut_email
        ]);

        return response()->json([
            'message' => 'Data Direktur Utama berhasil disimpan'
        ], Response::HTTP_OK);
    }

    public function edit($id)
    {
        $mDirut = mDirut::with('user')->find($id);
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('diruts.edit', compact('mDirut', 'levels'));
    }

    public function update(Request $request, $id)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $mDirut = mDirut::with('user')->find($id);
        if (!$mDirut) {
            return response()->json([
                'message' => 'Data dirut tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'dirut_nama' => 'required|string|max:100',
            'dirut_nip' => 'required|string|unique:m_diruts,dirut_nip,' . $id . ',dirut_id',
            'dirut_email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($id, $mDirut) {
                    if (
                        DB::table('m_diruts')
                        ->where('dirut_email', $value)
                        ->where('dirut_id', '!=', $id)
                        ->exists()
                    ) {
                        $fail('Email sudah digunakan di tabel Dirut.');
                    }

                    if (
                        DB::table('m_users')
                        ->where('email', $value)
                        ->where('user_id', '!=', $mDirut->user_id)
                        ->exists()
                    ) {
                        $fail('Email sudah digunakan di tabel User.');
                    }
                }
            ],
            'level_id' => 'required|exists:m_levels,level_id',
            'username' => 'required|string|unique:m_users,username,' . $mDirut->user_id . ',user_id',
            'password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $mDirut->update([
            'dirut_nama' => $request->dirut_nama,
            'dirut_nip' => $request->dirut_nip,
            'dirut_email' => $request->dirut_email
        ]);

        // update user
        $dataUser = [
            'username' => $request->username,
            'email' => $request->dirut_email,
            'name' => $request->dirut_nama,
            'level_id' => $request->level_id
        ];

        if ($request->password) {
            $dataUser['password'] = Hash::make($request->password);
        }

        return response()->json([
            'message' => 'Data Direktur Utama berhasil diperbarui'
        ], Response::HTTP_OK);
    }

    public function confirm(string $id)
    {
        $mDirut = mDirut::with('user')->find($id);
        return view('diruts.confirm-delete', compact('mDirut'));
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mDirut = mDirut::find($id);
            if (!$mDirut) {
                return response()->json([
                    'message' => 'Data dirut tidak ditemukan'
                ], Response::HTTP_NOT_FOUND);
            }

            $user = $mDirut->user;
            if ($user) {
                $mDirut->delete();
                $user->delete();
            }

            return response()->json([
                'message' => 'Data Direktur Utama dan user berhasil dihapus!'
            ], Response::HTTP_OK);
        }

        return redirect('/dashboard');
    }
}
