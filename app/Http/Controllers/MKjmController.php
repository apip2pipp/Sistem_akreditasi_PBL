<?php

namespace App\Http\Controllers;

use App\Models\mKjm;
use App\Models\mUser;
use App\Models\mLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MKjmController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = mKjm::select('kjm_id', 'kjm_nama', 'no_pegawai', 'kjm_email');
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar KJM',
            'list' => ['Home', 'KJM']
        ];

        $page = (object) [
            'title' => 'Daftar KJM yang terdaftar dalam sistem'
        ];

        return view('kjms.index', compact('breadcrumb', 'page'));
    }

    public function create()
    {
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('kjms.create', compact('levels'));
    }

    public function store(Request $request)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $validator = Validator::make($request->all(), [
            'kjm_nama' => 'required|string|max:100',
            'no_pegawai' => 'required|string|max:50|unique:m_kjms,no_pegawai',
            'kjm_email' => [
                'required',
                'email',
                'max:100',
                function ($attribute, $value, $fail) {
                    if (DB::table('m_kjms')->where('kjm_email', $value)->exists()) {
                        $fail('Email sudah digunakan di tabel KJM.');
                    }
                    if (DB::table('m_users')->where('email', $value)->exists()) {
                        $fail('Email sudah digunakan di tabel User.');
                    }
                },
            ],
            'level_id' => 'required|exists:m_levels,level_id',
            'username' => 'required|string|unique:m_users,username|max:100',
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
            'email' => $request->kjm_email,
            'name' => $request->kjm_nama,
            'level_id' => $request->level_id,
            'password' => Hash::make($request->password,),
        ]);

        mKjm::create([
            'user_id' => $user->user_id,
            'kjm_nama' => $request->kjm_nama,
            'no_pegawai' => $request->no_pegawai,
            'kjm_email' => $request->kjm_email,
        ]);

        return response()->json([
            'message' => 'Data KJM berhasil disimpan'
        ], Response::HTTP_OK);
    }

    public function edit($id)
    {
        $mKjm = mKjm::with('user')->find($id);
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('kjms.edit', compact('mKjm', 'levels'));
    }

    public function update(Request $request, $id)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $mKjm = mKjm::with('user')->find($id);
        if (!$mKjm) {
            return response()->json([
                'message' => 'Data KJM tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'kjm_nama' => 'required|string|max:100',
            'no_pegawai' => 'required|string|max:50|unique:m_kjms,no_pegawai,' . $id . ',kjm_id',
            'kjm_email' => [
                'required',
                'email',
                'max:100',
                function ($attribute, $value, $fail) use ($id, $mKjm) {
                    if (
                        DB::table('m_kjms')
                        ->where('kjm_email', $value)
                        ->where('kjm_id', '!=', $id)
                        ->exists()
                    ) {
                        $fail('Email sudah digunakan di tabel KJM.');
                    }

                    if (
                        DB::table('m_users')
                        ->where('email', $value)
                        ->where('user_id', '!=', $mKjm->user_id)
                        ->exists()
                    ) {
                        $fail('Email sudah digunakan di tabel User.');
                    }
                }
            ],
            'level_id' => 'required|exists:m_levels,level_id',
            'username' => 'required|string|unique:m_users,username,' . $mKjm->user_id . ',user_id|max:100',
            'password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        // $username = $request->no_pegawai;

        $mKjm->update([
            'kjm_nama' => $request->kjm_nama,
            'no_pegawai' => $request->no_pegawai,
            'kjm_email' => $request->kjm_email,
        ]);

        $dataUser = [
            'username' => $request->username,
            'email' => $request->kjm_email,
            'name' => $request->kjm_nama,
            'level_id' => $request->level_id,
        ];
        if ($request->password) {
            $dataUser['password'] = Hash::make($request->password);
        }

        $mKjm->user->update($dataUser);
        
        return response()->json([
            'message' => 'Data KJM berhasil diperbarui'
        ], Response::HTTP_OK);
    }

    public function confirm(string $id)
    {
        $mKjm = mKjm::with('user')->find($id);
        return view('kjms.confirm-delete', compact('mKjm'));
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mKjm = mKjm::find($id);
            if (!$mKjm) {
                return response()->json([
                    'message' => 'Data KJM tidak ditemukan'
                ], Response::HTTP_NOT_FOUND);
            }

            $user = $mKjm->user;
            if ($user) {
                $mKjm->delete();
                $user->delete();
            }

            return response()->json([
                'message' => 'Data KJM dan user berhasil dihapus!'
            ], Response::HTTP_OK);
        }

        return redirect('/dashboard');
    }
}
