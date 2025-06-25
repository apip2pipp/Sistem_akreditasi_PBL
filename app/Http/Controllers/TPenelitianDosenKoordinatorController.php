<?php

namespace App\Http\Controllers;

use App\Models\mDosen;
use App\Models\mPenelitian;
use App\Models\mUser;
use App\Models\tPenelitianDosen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TPenelitianDosenKoordinatorController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = tPenelitianDosen::with('dosen', 'penelitian')
                ->select('id_penelitian_dosen', 'user_id', 'penelitian_id', 'status') // <-- Diperbaiki di sini
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'List of Lecturer Research',
            'list' => ['Home', 'Lecturer Research']
        ];

        $page = (object)[
            'title' => 'List of faculty research projects registered in the system'
        ];
        return view('penelitian-dosen.koordinator.index', compact('breadcrumb', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataDosen = mUser::with('level')
            ->whereHas('level', function ($query) {
                $query->where('level_kode', 'DSN')
                    ->orWhere('level_nama', 'Dosen');
            })
            ->get();

        return view('penelitian-dosen.koordinator.create', compact('dataDosen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Store function called with data:', $request->all());
        if (!$request->ajax() && !$request->wantsJson()) {
            redirect('/dashboard');
        }
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|array', // ← ubah jadi array
            'user_id.*' => 'exists:m_users,user_id', // ← validasi tiap item
            'no_surat_tugas' => 'required',
            'judul_penelitian' => 'required',
            'pendanaan_internal' => 'nullable',
            'pendanaan_eksternal' => 'nullable',
            'link_penelitian' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        // Simpan penelitian
        $penelitian = mPenelitian::create([
            'no_surat_tugas' => $request->no_surat_tugas,
            'judul_penelitian' => $request->judul_penelitian,
            'pendanaan_internal' => $request->pendanaan_internal,
            'pendanaan_eksternal' => $request->pendanaan_eksternal,
            'link_penelitian' => $request->link_penelitian
        ]);

        // Simpan semua dosen ke tabel pivot
        foreach ($request->user_id as $dosenId) {
            tPenelitianDosen::create([
                'user_id' => $dosenId,
                'penelitian_id' => $penelitian->id_penelitian, // hati-hati: pakai nama PK yang benar
                'status' => 'pending'
            ]);
        }
        Log::info('Penelitian created: ', $penelitian->toArray());

        return response()->json([
            'message' => 'Research data with lecturers successfully saved'
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data t_penelitian_dosen berdasarkan id
        $penelitianDosen = tPenelitianDosen::findOrFail($id);

        // Ambil data penelitian dan dosen terkait
        $penelitian = $penelitianDosen->penelitian;
        $dataDosen = mUser::with('level')
            ->whereHas('level', function ($query) {
                $query->where('level_kode', 'DSN')
                    ->orWhere('level_nama', 'Dosen');
            })
            ->get();

        // Ambil data dosen yang sudah terhubung dengan penelitian ini
        $selectedDosenIds = tPenelitianDosen::where('penelitian_id', $penelitian->id_penelitian)
            ->pluck('user_id')
            ->toArray();

        // Kirim data ke view
        return view('penelitian-dosen.koordinator.edit', compact('penelitian', 'dataDosen', 'penelitianDosen', 'selectedDosenIds'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Log::info('Update function called with data:', $request->all());

        // Validasi data yang dikirimkan
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:m_users,user_id',
            'no_surat_tugas' => 'required',
            'judul_penelitian' => 'required',
            'pendanaan_internal' => 'nullable',
            'pendanaan_eksternal' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        // Cari data t_penelitian_dosen berdasarkan id
        $penelitianDosen = tPenelitianDosen::findOrFail($id);

        if (!$penelitianDosen) {
            return response()->json([
                'message' => 'No research data from lecturers was found.'
            ], Response::HTTP_NOT_FOUND);
        }

        if ($penelitianDosen->status == 'accepted') {
            return response()->json([
                'message' => 'Research Approved by Lecturer Cannot Be Updated'
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($penelitianDosen->status == 'rejected') {
            return response()->json([
                'message' => 'Research has been rejected by lecturers and cannot be updated.'
            ], Response::HTTP_BAD_REQUEST);
        }

        // Cari data penelitian terkait
        $penelitian = $penelitianDosen->penelitian;

        // Update data penelitian jika perlu
        $penelitian->update([
            'no_surat_tugas' => $request->no_surat_tugas ?? $penelitian->no_surat_tugas,
            'judul_penelitian' => $request->judul_penelitian ?? $penelitian->judul_penelitian,
            'pendanaan_internal' => $request->pendanaan_internal ?? $penelitian->pendanaan_internal,
            'pendanaan_eksternal' => $request->pendanaan_eksternal ?? $penelitian->pendanaan_eksternal,
        ]);

        // Update data dosen yang terhubung dengan penelitian ini
        $penelitianDosen->update([
            'user_id' => $request->user_id,
            'status' => 'pending',
        ]);

        Log::info('Penelitian updated: ', $penelitian->toArray());

        return response()->json([
            'message' => 'Research data and lecturers successfully updated'
        ], Response::HTTP_OK);
    }

    public function confirm(string $id)
    {
        $penelitianDosen = tPenelitianDosen::find($id);
        return view('penelitian-dosen.koordinator.confirm-delete', compact('penelitianDosen'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $penelitianDosen = tPenelitianDosen::find($id);
            // dd($penelitianDosen);
            if (!$penelitianDosen) {
                return response()->json([
                    'message' => 'Data not found'
                ], Response::HTTP_NOT_FOUND);
            }

            if ($penelitianDosen->status == 'accepted') {
                return response()->json([
                    'message' => 'Research that has been approved by a lecturer cannot be deleted.'
                ], Response::HTTP_BAD_REQUEST);
            }

            if ($penelitianDosen->status == 'rejected') {
                return response()->json([
                    'message' => 'Research that has been rejected by lecturers cannot be deleted.'
                ], Response::HTTP_BAD_REQUEST);
            }

            try {
                $penelitianDosen->delete();

                Log::info("tPenelitianDosen ID $id berhasil dihapus.");

                return response()->json([
                    'message' => 'The relationship between lecturers in the study was successfully removed.!'
                ], Response::HTTP_OK);
            } catch (\Exception $e) {
                Log::error("Gagal menghapus tPenelitianDosen ID $id: " . $e->getMessage());

                return response()->json([
                    'message' => 'An error occurred while deleting data.'
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        return redirect('/dashboard');
    }
}
