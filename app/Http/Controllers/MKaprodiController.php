<?php

namespace App\Http\Controllers;

use App\Models\mKaprodi;
use App\Models\mUser;
use App\Models\mLevel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MKaprodiController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = mKaprodi::select('kaprodi_id', 'kaprodi_nama', 'kaprodi_prodi', 'kaprodi_gender', 'kaprodi_email');

            if ($request->filled('kaprodi_prodi')) {
                $data = $data->where('kaprodi_prodi', $request->kaprodi_prodi);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Kaprodi',
            'list' => ['Home', 'Kaprodi']
        ];

        $page = (object) [
            'title' => 'Daftar kaprodi yang terdaftar dalam sistem'
        ];

        return view('kaprodis.index', compact('breadcrumb', 'page'));
    }

    public function create()
    {
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('kaprodis.create', compact('levels'));
    }

    public function store(Request $request)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $validator = Validator::make($request->all(), [
            'kaprodi_nama' => 'required|string|max:100',
            'kaprodi_prodi' => 'required|string|in:D-IV Teknik Informatika,D-IV Sistem Informasi Bisnis,D-II Pengembangan Perangkat Lunak',
            'kaprodi_nidn' => 'nullable|string|required_without:kaprodi_nip|unique:m_kaprodis,kaprodi_nidn',
            'kaprodi_nip' => 'nullable|string|required_without:kaprodi_nidn|unique:m_kaprodis,kaprodi_nip',
            'kaprodi_gender' => 'required|in:L,P',
            'kaprodi_email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (DB::table('m_kaprodis')->where('kaprodi_email', $value)->exists()) {
                        $fail('Email sudah digunakan di tabel Kaprodi.');
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

        // Ambil username default: prioritas NIP, fallback ke NIDN
        // $username = !empty($request->kaprodi_nip) ? $request->kaprodi_nip : $request->kaprodi_nidn;

        // Buat akun user
        $user = mUser::create([
            'username' => $request->username,
            'email' => $request->kaprodi_email,
            'name' => $request->kaprodi_nama,
            'level_id' => $request->level_id,
            'password' => Hash::make($request->password),
        ]);

        // Simpan data kaprodi
        mKaprodi::create([
            'user_id' => $user->user_id,
            'kaprodi_nama' => $request->kaprodi_nama,
            'kaprodi_prodi' => $request->kaprodi_prodi,
            'kaprodi_nidn' => $request->kaprodi_nidn ?? null,
            'kaprodi_nip' => $request->kaprodi_nip ?? null,
            'kaprodi_gender' => $request->kaprodi_gender,
            'kaprodi_email' => $request->kaprodi_email
        ]);

        return response()->json([
            'message' => 'Data kaprodi berhasil disimpan'
        ], Response::HTTP_OK);
    }


    public function edit($id)
    {
        $mKaprodi = mKaprodi::with('user')->find($id);
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('kaprodis.edit', compact('mKaprodi', 'levels'));
    }

    public function update(Request $request, $id)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $mKaprodi = mKaprodi::with('user')->find($id);
        if (!$mKaprodi) {
            return response()->json([
                'message' => 'Data kaprodi tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'kaprodi_nama' => 'required|string|max:100',
            'kaprodi_prodi' => 'required|string|max:100',
            'kaprodi_nidn' => 'nullable|string|required_without:kaprodi_nip|unique:m_kaprodis,kaprodi_nidn,' . $id . ',kaprodi_id',
            'kaprodi_nip' => 'nullable|string|required_without:kaprodi_nidn|unique:m_kaprodis,kaprodi_nip,' . $id . ',kaprodi_id',
            'kaprodi_gender' => 'required|in:L,P',
            'kaprodi_email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($id, $mKaprodi) {
                    if (
                        DB::table('m_kaprodis')
                        ->where('kaprodi_email', $value)
                        ->where('kaprodi_id', '!=', $id)
                        ->exists()
                    ) {
                        $fail('Email sudah digunakan di tabel Kaprodi.');
                    }

                    if (
                        DB::table('m_users')
                        ->where('email', $value)
                        ->where('user_id', '!=', $mKaprodi->user_id)
                        ->exists()
                    ) {
                        $fail('Email sudah digunakan di tabel User.');
                    }
                }
            ],
            'level_id' => 'required|exists:m_levels,level_id',
            'username' => 'required|string|unique:m_users,username,' . $mKaprodi->user_id . ',user_id|max:100',
            'password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        // $username = !empty($request->kaprodi_nip) ? $request->kaprodi_nip : $request->kaprodi_nidn;

        // Update data kaprodi
        $mKaprodi->update([
            'kaprodi_nama' => $request->kaprodi_nama,
            'kaprodi_prodi' => $request->kaprodi_prodi ?? null,
            'kaprodi_nidn' => $request->kaprodi_nidn ?? null,
            'kaprodi_nip' => $request->kaprodi_nip,
            'kaprodi_gender' => $request->kaprodi_gender,
            'kaprodi_email' => $request->kaprodi_email,
        ]);

        // Update data user
        $dataUser = [
            'username' => $request->username,
            'email' => $request->kaprodi_email,
            'name' => $request->kaprodi_nama,
            'level_id' => $request->level_id,
        ];

        if (!empty($request->password)) {
            $dataUser['password'] = Hash::make($request->password);
        }

        $mKaprodi->user->update($dataUser);


        return response()->json([
            'message' => 'Data kaprodi berhasil diperbarui'
        ], Response::HTTP_OK);
    }



    public function confirm(string $id)
    {
        $mKaprodi = mKaprodi::with('user')->find($id);
        return view('kaprodis.confirm-delete', compact('mKaprodi'));
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mKaprodi = mKaprodi::find($id);
            if (!$mKaprodi) {
                return response()->json([
                    'message' => 'Data kaprodi tidak ditemukan'
                ], Response::HTTP_NOT_FOUND);
            }

            $user = $mKaprodi->user;
            if ($user) {
                $mKaprodi->delete();
                $user->delete();
            }

            return response()->json([
                'message' => 'Data kaprodi dan user berhasil dihapus!'
            ], Response::HTTP_OK);
        }

        return redirect('/dashboard');
    }
}
