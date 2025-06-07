<?php

namespace App\Http\Controllers;

use App\Models\mDosen;
use App\Models\mLevel;
use App\Models\mUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DosenExport;
use App\Imports\DosenImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class MDosenController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = mDosen::select('dosen_id', 'nama_dosen');
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Dosen',
            'list' => ['Home', 'Dosen']
        ];

        $page = (object) [
            'title' => 'Daftar dosen yang terdaftar dalam sistem'
        ];

        // $user = Auth::user();
        // $level = $user->level->level_kode;

        // if ($level != 'ADM') {
        //     // abord 403
        //     abort(403);
        // }
        return view('dosens.index', compact('breadcrumb', 'page'));
    }

    public function create()
    {
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('dosens.create', compact('levels'));
    }

    public function store(Request $request)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $validator = Validator::make($request->all(), [
            'dosen_nip' => 'required|string|required_without:dosen_nidn|unique:m_dosens,dosen_nip',
            'dosen_nidn' => 'nullable|string|required_without:dosen_nip|unique:m_dosens,dosen_nidn',
            'dosen_nama' => 'required|string|max:100',
            'dosen_nidn' => 'nullable|string',
            'dosen_email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (DB::table('m_dosens')->where('dosen_email', $value)->exists()) {
                        $fail('Email sudah digunakan di tabel Dosen.');
                    }

                    if (DB::table('m_users')->where('email', $value)->exists()) {
                        $fail('Email sudah digunakan di tabel User.');
                    }
                },
            ],

            'dosen_gender' => 'required|in:L,P',
            'level_id' => 'required|exists:m_levels,level_id',
            'username' => 'required|string|unique:m_users,username',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        // Buat akun user otomatis
        $user = mUser::create([
            'username' => $request->username,
            'email' => $request->dosen_email,
            'name' => $request->dosen_nama,
            'level_id' => $request->level_id,
            'password' => Hash::make($request->password),
        ]);

        // Simpan data dosen dengan user_id
        mDosen::create(array_merge(
            $request->all(),
            ['user_id' => $user->user_id] // <- gunakan user_id sesuai model
        ));

        return response()->json([
            'message' => 'Data dosen berhasil disimpan'
        ], Response::HTTP_OK);
    }


    public function edit($id)
    {
        $mDosen = mDosen::with('user')->find($id);
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('dosens.edit', compact('mDosen', 'levels'));
    }

    public function update(Request $request, string $id)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $mDosen = mDosen::with('user')->find($id);
        if (!$mDosen) {
            return response()->json([
                'message' => 'Data dosen tidak ditemukan'
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'dosen_nip' => "required|string|unique:m_dosens,dosen_nip,$id,dosen_id|required_without:dosen_nidn",
            'dosen_nidn' => "nullable|string|unique:m_dosens,dosen_nidn,$id,dosen_id|required_without:dosen_nip",
            'dosen_nama' => 'required|string|max:100',
            'dosen_nidn' => 'nullable|string',
            'dosen_email' => "required|email|unique:m_dosens,dosen_email,$id,dosen_id",
            'dosen_gender' => 'required|in:L,P',
            'level_id' => 'required|exists:m_levels,level_id',
            'username' => 'required|string|unique:m_users,username,' . $mDosen->user_id . ',user_id|max:100',
            'password' => 'nullable|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }



        // $username = !empty($request->dosen_nip) ? $request->dosen_nip : $request->dosen_nidn;

        // Update data dosen
        $mDosen->update([
            'dosen_nip' => $request->dosen_nip,
            'dosen_nidn' => $request->dosen_nidn ?? null,
            'dosen_nama' => $request->dosen_nama ?? null,
            'dosen_nidn' => $request->dosen_nidn,
            'dosen_email' => $request->dosen_email,
            'dosen_gender' => $request->dosen_gender,
        ]);

        // Update data user jika ada
        $dataUser = [
            'username' => $request->username,
            'email' => $request->dosen_email,
            'level_id' => $request->level_id,
            'name' => $request->dosen_nama,
        ];
        if (!empty($request->password)) {
            $dataUser['password'] = Hash::make($request->password);
        }
        $mDosen->user->update($dataUser);
        return response()->json([
            'message' => 'Data dosen berhasil diperbarui'
        ], Response::HTTP_OK);
    }


    public function confirm(string $id)
    {
        $mDosen = mDosen::find($id);
        $level = mLevel::find($mDosen->user->level_id);
        // level
        return view('dosens.confirm-delete', compact('mDosen'));
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Cari data dosen berdasarkan ID
            $mDosen = mDosen::find($id);

            // Jika data dosen tidak ditemukan, kembalikan response error
            if (!$mDosen) {
                return response()->json([
                    'message' => 'Data dosen tidak ditemukan'
                ], Response::HTTP_NOT_FOUND);
            }

            // Menghapus user yang terhubung dengan dosen
            $user = $mDosen->user;
            // dd($user);
            if ($user) {
                // Menghapus dosen
                $mDosen->delete();
                $user->delete(); // Menghapus user terkait dosen
            }

            return response()->json([
                'message' => 'Data dosen dan user berhasil dihapus!'
            ], Response::HTTP_OK);
        }

        return redirect('/dashboard');
    }

    public function importForm()
    {
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('dosens.import', compact('levels'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'level_id' => 'required|exists:m_levels,level_id'
        ]);

        try {
            // Create a new import instance
            $import = new DosenImport($request->level_id);

            // Perform the import
            Excel::import($import, $request->file('file'));

            // Get the failed rows from the import instance
            $failedRows = $import->getFailedRows();

            // If there are failed rows, return them in the response
            if (count($failedRows) > 0) {
                return response()->json([
                    'message' => 'Data dosen berhasil diimport dengan beberapa kegagalan!',
                    'failed_rows' => $failedRows
                ], Response::HTTP_OK);
            }

            return response()->json([
                'message' => 'Data dosen berhasil diimport!'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Import gagal: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function export()
    {
        try {
            // Export data to Excel
            return Excel::download(new DosenExport, 'data_dosen.xlsx');
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Export gagal: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
