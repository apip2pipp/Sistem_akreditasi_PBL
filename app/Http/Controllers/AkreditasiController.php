<?php

namespace App\Http\Controllers;

use App\Models\mKriteria;
use App\Models\tAkreditasi;
use App\Models\tEvaluasi;
use App\Models\tFileAkreditasi;
use App\Models\tGambarEvaluasi;
use App\Models\tGambarPelaksanaan;
use App\Models\tGambarPenetapan;
use App\Models\tGambarPengendalian;
use App\Models\tGambarPeningkatan;
use App\Models\tPelaksanaan;
use App\Models\tPenetapan;
use App\Models\tPengendalian;
use App\Models\tPeningkatan;
use App\Models\tStatusAkreditasi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AkreditasiController extends Controller
{
    public function list(Request $request, $slug)
    {
        $kriteria = mKriteria::where('route', $slug)->first();
        if (!$kriteria) {
            return abort(404);
        }
        $user = Auth::user();
        $roleKode = $user->level->level_kode;
        $roleNama = $user->level->level_nama;
        // dd($role);
        if ($roleKode === 'KDR' || $roleNama === 'Koordinator') {
            $akreditasi = tFileAkreditasi::with(['akreditasi' => function ($query) {
                $query->select('id_akreditasi', 'judul_ppepp'); // Make sure to select only the necessary fields
            }])
                ->whereHas('akreditasi', function ($query) use ($kriteria) {
                    $query->where('kriteria_id', $kriteria->kriteria_id);
                })
                ->select('akreditasi_id', 'id_file_akreditasi', 'file_akreditasi', 'statusFile') // Select relevant fields from tFileAkreditasi
                ->get();
        } else {
            $akreditasi = tAkreditasi::where('kriteria_id', $kriteria->kriteria_id)
                ->where('status', '!=', 'draft')
                ->select('id_akreditasi', 'judul_ppepp', 'status')
                ->get();
            // dd($akreditasi);
        }

        return DataTables::of($akreditasi)
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     */

    public function index($slug)
    {
        $kriteria = mKriteria::where('route', $slug)->first();
        if (!$kriteria) {
            return abort(404);
        }
        $breadcrumb = (object)[
            'title' => 'List' . ' ' . $kriteria->nama_kriteria,
            'list' => ['Home', $kriteria->nama_kriteria]
        ];

        $page = (object)[
            'title' => 'List' . ' ' . $kriteria->nama_kriteria
        ];
        $user = Auth::user();
        $roleKode = $user->level->level_kode;
        $roleNama = $user->level->level_nama;
        if ($roleNama === 'Koordinator' || $roleKode === 'KDR') {
            return view('akreditasi.index', compact('kriteria', 'breadcrumb', 'page'));
        } else {
            return view('akreditasi2.index', compact('kriteria', 'breadcrumb', 'page'));
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function draft(Request $request, $slug)
    {
        Log::info("Accreditation draft begins for slug: {$slug}");

        $kriteria = mKriteria::where('route', $slug)->firstOrFail();
        Log::info("Criteria found", ['kriteria_id' => $kriteria->kriteria_id]);

        // Validasi input
        $validated = $request->validate([
            'penetapan' => 'required|string',
            'pelaksanaan' => 'required|string',
            'evaluasi' => 'required|string',
            'pengendalian' => 'required|string',
            'peningkatan' => 'required|string',

            'gambar_penetapan.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'gambar_pelaksanaan.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'gambar_evaluasi.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'gambar_pengendalian.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'gambar_peningkatan.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',

            'judul_ppepp' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            Log::info("Saving text data...");

            $penetapan = tPenetapan::create(['penetapan' => $validated['penetapan']]);
            $pelaksanaan = tPelaksanaan::create(['pelaksanaan' => $validated['pelaksanaan']]);
            $evaluasi = tEvaluasi::create(['evaluasi' => $validated['evaluasi']]);
            $pengendalian = tPengendalian::create(['pengendalian' => $validated['pengendalian']]);
            $peningkatan = tPeningkatan::create(['peningkatan' => $validated['peningkatan']]);

            Log::info("Text data successfully saved", [
                'penetapan_id' => $penetapan->id_penetapan,
                'pelaksanaan_id' => $pelaksanaan->id_pelaksanaan,
                'evaluasi_id' => $evaluasi->id_evaluasi,
                'pengendalian_id' => $pengendalian->id_pengendalian,
                'peningkatan_id' => $peningkatan->id_peningkatan,
            ]);

            Log::info("Menyimpan gambar jika ada...");
            // Simpan gambar jika ada
            if ($request->hasFile('gambar_penetapan')) {
                $this->simpanGambar($request, 'gambar_penetapan', tGambarPenetapan::class, 'penetapan_id', $penetapan->id_penetapan, 'gambar_penetapan');
            }
            if ($request->hasFile('gambar_pelaksanaan')) {
                $this->simpanGambar($request, 'gambar_pelaksanaan', tGambarPelaksanaan::class, 'pelaksanaan_id', $pelaksanaan->id_pelaksanaan, 'gambar_pelaksanaan');
            }
            if ($request->hasFile('gambar_evaluasi')) {
                $this->simpanGambar($request, 'gambar_evaluasi', tGambarEvaluasi::class, 'evaluasi_id', $evaluasi->id_evaluasi, 'gambar_evaluasi');
            }
            if ($request->hasFile('gambar_pengendalian')) {
                $this->simpanGambar($request, 'gambar_pengendalian', tGambarPengendalian::class, 'pengendalian_id', $pengendalian->id_pengendalian, 'gambar_pengendalian');
            }
            if ($request->hasFile('gambar_peningkatan')) {
                $this->simpanGambar($request, 'gambar_peningkatan', tGambarPeningkatan::class, 'peningkatan_id', $peningkatan->id_peningkatan, 'gambar_peningkatan');
            }


            $akreditasi = tAkreditasi::create([
                'judul_ppepp'    => $validated['judul_ppepp'],
                'kriteria_id'     => $kriteria->kriteria_id,
                'penetapan_id'    => $penetapan->id_penetapan,
                'pelaksanaan_id'  => $pelaksanaan->id_pelaksanaan,
                'evaluasi_id'     => $evaluasi->id_evaluasi,
                'pengendalian_id' => $pengendalian->id_pengendalian,
                'peningkatan_id'  => $peningkatan->id_peningkatan,
                'koordinator_id'  => auth()->user()->user_id,
                'status'          => 'draft',
            ]);

            Log::info("Accreditation successfully created", ['akreditasi_id' => $akreditasi->id_akreditasi]);

            $akreditasi->refresh(); // Refresh semua relasi
            $akreditasi->load([
                'penetapan.gambarPenetapan',
                'pelaksanaan.gambarPelaksanaan',
                'evaluasi.gambarEvaluasi',
                'pengendalian.gambarPengendalian',
                'peningkatan.gambarPeningkatan',
            ]);


            Log::info("Load data akreditasi", [
                'penetapan_id' => $akreditasi->penetapan->id_penetapan,
                'pelaksanaan_id' => $akreditasi->pelaksanaan->id_pelaksanaan,
                'evaluasi_id' => $akreditasi->evaluasi->id_evaluasi,
                'pengendalian_id' => $akreditasi->pengendalian->id_pengendalian,
                'peningkatan_id' => $akreditasi->peningkatan->id_peningkatan,
            ]);


            $pdf = Pdf::loadView('akreditasi.pdf', compact('akreditasi'));
            $pdfPath = "akreditasi/{$akreditasi->judul_ppepp}.pdf";
            $pdf->save(storage_path("app/public/{$pdfPath}"));

            Log::info("PDF draft saved", ['path' => $pdfPath]);

            tFileAkreditasi::create([
                'akreditasi_id'  => $akreditasi->id_akreditasi,
                'file_akreditasi' => $pdfPath,
                'status_kaprodi' => null,
                'komentar_kaprodi' => null,
                'tanggal_waktu_kaprodi' => null,
                'kaprodi_id'     => null,
                'status_kajur' => null,
                'komentar_kajur' => null,
                'tanggal_waktu_kajur' => null,
                'kajur_id'     => null,
                'status_kjm' => null,
                'komentar_kjm' => null,
                'tanggal_waktu_kjm' => null,
                'kjm_id'     => null,
                'status_direktur_utama' => null,
                'komentar_direktur_utama' => null,
                'tanggal_waktu_direktur_utama' => null,
                'direktur_utama_id'     => null,
                'statusFile' => 'draft'
            ]);

            DB::commit();

            Log::info("The accreditation draft has been successfully saved and committed..");
            return back()->with('success', 'The accreditation draft has been successfully saved.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to save accreditation draft", ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Failed to save draft: ' . $e->getMessage()]);
        }
    }

    public function showDraft($id_akreditasi)
    {
        $akreditasi = tAkreditasi::with([
            'penetapan.gambarPenetapan',
            'pelaksanaan.gambarPelaksanaan',
            'evaluasi.gambarEvaluasi',
            'pengendalian.gambarPengendalian',
            'peningkatan.gambarPeningkatan'
        ])
            ->findOrFail($id_akreditasi);
        $fileAkreditasi = tFileAkreditasi::where('akreditasi_id', $id_akreditasi)->latest('created_at')->first();

        $breadcrumb = (object)[
            'title' => 'List' . ' ' . $akreditasi->kriteria->nama_kriteria,
            'list' => ['Home', $akreditasi->kriteria->nama_kriteria]
        ];

        $page = (object)[
            'title' => 'List' . ' ' . $akreditasi->kriteria->nama_kriteria
        ];

        return view('akreditasi.show', compact('akreditasi', 'fileAkreditasi', 'breadcrumb', 'page'));
    }

    public function showDraft2($id_akreditasi)
    {
        $akreditasi = tAkreditasi::with([
            'penetapan.gambarPenetapan',
            'pelaksanaan.gambarPelaksanaan',
            'evaluasi.gambarEvaluasi',
            'pengendalian.gambarPengendalian',
            'peningkatan.gambarPeningkatan'
        ])
            ->findOrFail($id_akreditasi);
        $fileAkreditasi = tFileAkreditasi::where('akreditasi_id', $id_akreditasi)->latest('created_at')->first();

        $fileAkreditasiShow = tFileAkreditasi::where('akreditasi_id', $id_akreditasi)->get();

        $breadcrumb = (object)[
            'title' => 'List' . ' ' . $akreditasi->kriteria->nama_kriteria,
            'list' => ['Home', $akreditasi->kriteria->nama_kriteria]
        ];

        $page = (object)[
            'title' => 'List' . ' ' . $akreditasi->kriteria->nama_kriteria
        ];

        return view('akreditasi2.show', compact('akreditasi', 'fileAkreditasi', 'breadcrumb', 'page', 'fileAkreditasiShow'));
    }

    public function editDraft($id_akreditasi)
    {
        $akreditasi = tAkreditasi::with([
            'penetapan.gambarPenetapan',
            'pelaksanaan.gambarPelaksanaan',
            'evaluasi.gambarEvaluasi',
            'pengendalian.gambarPengendalian',
            'peningkatan.gambarPeningkatan',
            'fileAkreditasi.kaprodi',
            'fileAkreditasi.kajur',
            'fileAkreditasi.kjm',
            'fileAkreditasi.direkturUtama'
        ])
            ->findOrFail($id_akreditasi);
        if ($akreditasi->status != 'draft') {
            return redirect()->route('akreditasi.index', ['slug' => $akreditasi->kriteria->route])->with('error', 'Data akreditasi Sudah Final.');
        }
        $fileAkreditasi = tFileAkreditasi::where('akreditasi_id', $id_akreditasi)->latest('created_at')->first();

        $breadcrumb = (object)[
            'title' => 'List' . ' ' . $akreditasi->kriteria->nama_kriteria,
            'list' => ['Home', $akreditasi->kriteria->nama_kriteria]
        ];

        $page = (object)[
            'title' => 'List' . ' ' . $akreditasi->kriteria->nama_kriteria
        ];
        return view('akreditasi.editDraft', compact('akreditasi', 'fileAkreditasi', 'breadcrumb', 'page'));
    }

    public function updateDraft(Request $request, $id_akreditasi)
    {
        Log::info("Update accreditation draft started for id_akreditasi: {$id_akreditasi}");

        $akreditasi = tAkreditasi::with([
            'fileAkreditasi',
            'penetapan.gambarPenetapan',
            'pelaksanaan.gambarPelaksanaan',
            'evaluasi.gambarEvaluasi',
            'pengendalian.gambarPengendalian',
            'peningkatan.gambarPeningkatan'
        ])->findOrFail($id_akreditasi);
        // dd($akreditasi);
        // dd($request->all());
        // Validasi input
        $validated = $request->validate([
            'judul_ppepp' => 'required|string',
            'penetapan' => 'required|string',
            'pelaksanaan' => 'required|string',
            'evaluasi' => 'required|string',
            'pengendalian' => 'required|string',
            'peningkatan' => 'required|string',
            'gambar_penetapan.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'gambar_pelaksanaan.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'gambar_evaluasi.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'gambar_pengendalian.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'gambar_peningkatan.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        // dd($validated);
        Log::info("Data validation successful.", ['validated_data' => $validated]);

        DB::beginTransaction();
        try {
            Log::info("Saving text data...");

            // Update data teks
            $akreditasi->update([
                'judul_ppepp' => $validated['judul_ppepp'],
            ]);
            $akreditasi->penetapan->update(['penetapan' => $validated['penetapan']]);
            $akreditasi->pelaksanaan->update(['pelaksanaan' => $validated['pelaksanaan']]);
            $akreditasi->evaluasi->update(['evaluasi' => $validated['evaluasi']]);
            $akreditasi->pengendalian->update(['pengendalian' => $validated['pengendalian']]);
            $akreditasi->peningkatan->update(['peningkatan' => $validated['peningkatan']]);

            log::info($akreditasi->penetapan);
            log::info($akreditasi->pelaksanaan);
            log::info($akreditasi->evaluasi);
            log::info($akreditasi->pengendalian);
            log::info($akreditasi->peningkatan);

            // Hapus gambar yang dipilih
            foreach (['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'] as $bagian) {
                $hapusGambarField = 'hapus_gambar_' . $bagian;
                if ($request->has($hapusGambarField)) {
                    foreach ($request->$hapusGambarField as $gambarId) {
                        // Mengakses gambar melalui relasi yang benar
                        $gambar = $akreditasi->$bagian->{"gambar" . ucfirst($bagian)}()->find($gambarId);

                        // Cek apakah gambar ditemukan
                        if (!$gambar) {
                            Log::error("File with ID {$gambarId} not found in section {$bagian}");
                            continue; // Skip ke gambar berikutnya
                        }

                        // Periksa apakah properti gambar ada dan memiliki path yang valid
                        $gambarPath = $gambar->{"gambar_" . $bagian};  // Akses kolom yang sesuai, misalnya gambar_penetapan

                        if (empty($gambarPath)) {
                            Log::error("File with ID {$gambarId} does not have an image path.");
                            continue; // Skip jika path gambar tidak ada
                        }

                        // Menghapus gambar dari penyimpanan
                        if (Storage::disk('public')->exists($gambarPath)) {
                            Storage::disk('public')->delete($gambarPath);  // Menghapus file gambar
                            $gambar->delete();  // Menghapus entri gambar dari database
                            Log::info("File {$gambarId} successfully deleted.");
                        } else {
                            Log::error("Image file not found in storage: {$gambarPath}");
                        }
                    }
                }
            }

            // Simpan gambar baru jika ada
            if ($request->hasFile('gambar_penetapan')) {
                $this->simpanGambar($request, 'gambar_penetapan', tGambarPenetapan::class, 'penetapan_id', $akreditasi->penetapan->id_penetapan, 'gambar_penetapan');
            }
            if ($request->hasFile('gambar_pelaksanaan')) {
                $this->simpanGambar($request, 'gambar_pelaksanaan', tGambarPelaksanaan::class, 'pelaksanaan_id', $akreditasi->pelaksanaan->id_pelaksanaan, 'gambar_pelaksanaan');
            }
            if ($request->hasFile('gambar_evaluasi')) {
                $this->simpanGambar($request, 'gambar_evaluasi', tGambarEvaluasi::class, 'evaluasi_id', $akreditasi->evaluasi->id_evaluasi, 'gambar_evaluasi');
            }
            if ($request->hasFile('gambar_pengendalian')) {
                $this->simpanGambar($request, 'gambar_pengendalian', tGambarPengendalian::class, 'pengendalian_id', $akreditasi->pengendalian->id_pengendalian, 'gambar_pengendalian');
            }
            if ($request->hasFile('gambar_peningkatan')) {
                $this->simpanGambar($request, 'gambar_peningkatan', tGambarPeningkatan::class, 'peningkatan_id', $akreditasi->peningkatan->id_peningkatan, 'gambar_peningkatan');
            }

            DB::commit();

            Log::info("The accreditation draft has been successfully updated and the PDF has been successfully created.");
            return redirect()->back()->with('success', 'The accreditation draft has been successfully updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to update accreditation draft", ['error' => $e->getMessage()]);
            return redirect()->route('akreditasi.index', ['slug' => $akreditasi->kriteria->route])->withErrors(['error' => 'Gagal memperbarui draft: ' . $e->getMessage()]);
        }
    }

    public function generatePdfUpdateAkreditasi($id)
    {
        // Ambil ulang dari DB agar data dan relasi benar-benar segar
        $akreditasi = tAkreditasi::with([
            'penetapan.gambarPenetapan',
            'pelaksanaan.gambarPelaksanaan',
            'evaluasi.gambarEvaluasi',
            'pengendalian.gambarPengendalian',
            'peningkatan.gambarPeningkatan',
        ])->where('id_akreditasi', $id)->first();
        // dd($akreditasi);
        if (!$akreditasi) {
            return response()->json(['error' => 'Accreditation data not found'], 404);
        }
        $akreditasi->refresh();
        // Refresh & load relasi agar data paling baru digunakan
        $akreditasi->load([
            'penetapan.gambarPenetapan',
            'pelaksanaan.gambarPelaksanaan',
            'evaluasi.gambarEvaluasi',
            'pengendalian.gambarPengendalian',
            'peningkatan.gambarPeningkatan',
        ]);
        // dd($akreditasi);
        $pdf = Pdf::loadView('akreditasi.pdf', compact('akreditasi'));
        $pdfPath = "akreditasi/{$akreditasi->judul_ppepp}.pdf";
        $pdf->save(storage_path("app/public/{$pdfPath}"));

        // dd($pdfPath, $pdf);

        Log::info("PDF accreditation saved again", ['path' => $pdfPath]);

        // Update atau buat entri file akreditasi
        $file = $akreditasi->fileAkreditasi()->latest('created_at')->first();
        // dd
        if ($file) {
            // Hapus file lama jika ada
            // if ($file->file_akreditasi && Storage::disk('public')->exists($file->file_akreditasi)) {
            //     Storage::disk('public')->delete($file->file_akreditasi);
            // }

            $file->update(['file_akreditasi' => $pdfPath]);
            Log::info("Mulai menyimpan PDF ke {$pdfPath}");
        } else {
            tFileAkreditasi::create([
                'akreditasi_id' => $akreditasi->id_akreditasi,
                'file_akreditasi' => $pdfPath,
            ]);
        }

        return response()->json(['message' => 'The accreditation PDF has been successfully updated..']);
    }



    public function final($id_akreditasi)
    {
        DB::beginTransaction();
        try {
            $akreditasi = tAkreditasi::findOrFail($id_akreditasi);
            $fileAkreditasi = tFileAkreditasi::with('akreditasi')->where('akreditasi_id', $id_akreditasi)
                ->latest('created_at')->first();
            if ($fileAkreditasi->akreditasi->status == 'final') {
                return response()->json([
                    'error' => 'Accreditation has been finalized'
                ], 422); // You should return a 400 status code for validation errors
            }

            $akreditasi->update(['status' => 'final']);

            $fileAkreditasi->update([
                'status_kaprodi' => 'Pending',
                'komentar_kaprodi' => null,
                'status_kajur' => 'Pending',
                'komentar_kajur' => null,
                'status_kjm' => 'Pending',
                'komentar_kjm' => null,
                'status_direktur_utama' => 'Pending',
                'komentar_direktur_utama' => null,
                'statusFile' => 'Final'
            ]);

            DB::commit();
            return back()->with('success', 'Accreditation status successfully finalized.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed finalization: ' . $e->getMessage()]);
        }
    }

    public function RevisiDraft($id_akreditasi)
    {
        $akreditasi = tAkreditasi::with([
            'penetapan.gambarPenetapan',
            'pelaksanaan.gambarPelaksanaan',
            'evaluasi.gambarEvaluasi',
            'pengendalian.gambarPengendalian',
            'peningkatan.gambarPeningkatan'
        ])
            ->findOrFail($id_akreditasi);
        if ($akreditasi->status != 'revisi') {
            return redirect()->route('akreditasi.index', ['slug' => $akreditasi->kriteria->route])->with('error', 'Data akreditasi Sudah Final.');
        }
        $fileAkreditasi = tFileAkreditasi::where('akreditasi_id', $id_akreditasi)->latest('created_at')->first();

        $showstatusandkomen = tFileAkreditasi::where('akreditasi_id', $id_akreditasi)->get();

        $breadcrumb = (object)[
            'title' => 'List' . ' ' . $akreditasi->kriteria->nama_kriteria,
            'list' => ['Home', $akreditasi->kriteria->nama_kriteria]
        ];

        $page = (object)[
            'title' => 'List' . ' ' . $akreditasi->kriteria->nama_kriteria
        ];
        return view('akreditasi.revisi', compact('akreditasi', 'fileAkreditasi', 'breadcrumb', 'page', 'showstatusandkomen'));
    }

    public function revisi(Request $request, $id_akreditasi)
    {
        $akreditasi = tAkreditasi::findOrFail($id_akreditasi);

        // Validasi input revisi
        $validated = $request->validate([
            'judul_ppepp' => 'required|string',
            'penetapan' => 'required',
            'pelaksanaan' => 'required',
            'evaluasi' => 'required',
            'pengendalian' => 'required',
            'peningkatan' => 'required',

            'gambar_penetapan.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'gambar_pelaksanaan.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'gambar_evaluasi.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'gambar_pengendalian.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'gambar_peningkatan.*' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::beginTransaction();
        try {

            if ($akreditasi->status != 'revisi') {
                return redirect()->route('akreditasi.index', ['slug' => $akreditasi->kriteria->route])->with('error', 'Data Akreditasi tidak dalam status Revisi.');
            }
            $fileAkreditasi = tFileAkreditasi::where('akreditasi_id', $id_akreditasi)->latest('created_at')->first();
            if ($fileAkreditasi->statusFile != 'Revisi') {
                return redirect()->route('akreditasi.index', ['slug' => $akreditasi->kriteria->route])->with('error', 'Data Akreditasi tidak dalam status Revisi.');
            }
            // Update data yang sudah ada
            $akreditasi->update([
                'judul_ppepp' => $validated['judul_ppepp'],
                'status' => 'draft',
            ]);
            $akreditasi->penetapan->update(['penetapan' => $validated['penetapan']]);
            $akreditasi->pelaksanaan->update(['pelaksanaan' => $validated['pelaksanaan']]);
            $akreditasi->evaluasi->update(['evaluasi' => $validated['evaluasi']]);
            $akreditasi->pengendalian->update(['pengendalian' => $validated['pengendalian']]);
            $akreditasi->peningkatan->update(['peningkatan' => $validated['peningkatan']]);

            foreach (['penetapan', 'pelaksanaan', 'evaluasi', 'pengendalian', 'peningkatan'] as $bagian) {
                $hapusGambarField = 'hapus_gambar_' . $bagian;
                if ($request->has($hapusGambarField)) {
                    foreach ($request->$hapusGambarField as $gambarId) {
                        // Mengakses gambar melalui relasi yang benar
                        $gambar = $akreditasi->$bagian->{"gambar" . ucfirst($bagian)}()->find($gambarId);

                        // Cek apakah gambar ditemukan
                        if (!$gambar) {
                            Log::error("File with ID {$gambarId} not found in section {$bagian}");
                            continue; // Skip ke gambar berikutnya
                        }

                        // Periksa apakah properti gambar ada dan memiliki path yang valid
                        $gambarPath = $gambar->{"gambar_" . $bagian};  // Akses kolom yang sesuai, misalnya gambar_penetapan

                        if (empty($gambarPath)) {
                            Log::error("File with ID {$gambarId} does not have an image path.");
                            continue; // Skip jika path gambar tidak ada
                        }

                        // Menghapus gambar dari penyimpanan
                        if (Storage::disk('public')->exists($gambarPath)) {
                            Storage::disk('public')->delete($gambarPath);  // Menghapus file gambar
                            $gambar->delete();  // Menghapus entri gambar dari database
                            Log::info("File {$gambarId} successfully deleted.");
                        } else {
                            Log::error("Image file not found in storage: {$gambarPath}");
                        }
                    }
                }
            }

            // Simpan gambar baru jika ada
            if ($request->hasFile('gambar_penetapan')) {
                $this->simpanGambar($request, 'gambar_penetapan', tGambarPenetapan::class, 'penetapan_id', $akreditasi->penetapan->id_penetapan, 'gambar_penetapan');
            }
            if ($request->hasFile('gambar_pelaksanaan')) {
                $this->simpanGambar($request, 'gambar_pelaksanaan', tGambarPelaksanaan::class, 'pelaksanaan_id', $akreditasi->pelaksanaan->id_pelaksanaan, 'gambar_pelaksanaan');
            }
            if ($request->hasFile('gambar_evaluasi')) {
                $this->simpanGambar($request, 'gambar_evaluasi', tGambarEvaluasi::class, 'evaluasi_id', $akreditasi->evaluasi->id_evaluasi, 'gambar_evaluasi');
            }
            if ($request->hasFile('gambar_pengendalian')) {
                $this->simpanGambar($request, 'gambar_pengendalian', tGambarPengendalian::class, 'pengendalian_id', $akreditasi->pengendalian->id_pengendalian, 'gambar_pengendalian');
            }
            if ($request->hasFile('gambar_peningkatan')) {
                $this->simpanGambar($request, 'gambar_peningkatan', tGambarPeningkatan::class, 'peningkatan_id', $akreditasi->peningkatan->id_peningkatan, 'gambar_peningkatan');
            }


            // Hitung revisi keberapa
            $versi = tFileAkreditasi::where('akreditasi_id', $id_akreditasi)->count();
            $fileName = "akreditasi/{$id_akreditasi}_rev{$versi}.pdf";

            // Generate file PDF revisi
            $pdf = Pdf::loadView('akreditasi.pdf', compact('akreditasi'));
            $pdf->save(storage_path("app/public/{$fileName}"));

            // Simpan file revisi ke database
            $fileBaru = tFileAkreditasi::create([
                'akreditasi_id' => $id_akreditasi,
                'file_akreditasi' => $fileName,
                'statusFile' => 'Draft',
            ]);

            DB::commit();
            return back()->with('success', 'Revision successfully saved. Please finalize again.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to save revision: ' . $e->getMessage()]);
        }
    }


    private function simpanGambar(Request $request, $fieldName, $modelClass, $foreignKey, $foreignId, $fileColumn)
    {
        if ($request->hasFile($fieldName)) {
            foreach ($request->file($fieldName) as $file) {
                $path = $file->store("akreditasi/{$fieldName}", 'public');
                $mimeType = $file->getClientMimeType();

                $modelClass::create([
                    $foreignKey => $foreignId,
                    $fileColumn => $path,
                    'mime_type' => $mimeType,
                ]);
            }
        }
        Log::info("Saving images to a table {$modelClass}", [
            'foreignKey' => $foreignKey,
            'foreignId' => $foreignId,
            'path' => $path,
        ]);
    }


    public function updateStatusKaprodi(Request $request, $id_akreditasi)
    {
        DB::beginTransaction();
        try {
            $akreditasi = tAkreditasi::findOrFail($id_akreditasi);
            $fileAkreditasi = tFileAkreditasi::where('akreditasi_id', $id_akreditasi)
                ->latest('created_at')->first();
            // dd($akreditasi, $fileAkreditasi);
            $kaprodiId = auth()->user();
            if (!$kaprodiId) {
                return back()->with('error', 'Failed to retrieve program coordinator data from logged-in user');
            }
            $fileAkreditasi->update([
                'status_kaprodi' => $request->status_kaprodi,
                'komentar_kaprodi' => $request->komentar_kaprodi,
                'kaprodi_id' => auth()->user()->user_id,
                'tanggal_waktu_kaprodi' => now(),
            ]);

            if ($request->status_kaprodi === 'Ditolak') {
                $akreditasi->update(['status' => 'revisi']);
                $fileAkreditasi->update(['statusFile' => 'Revisi']);
            }

            DB::commit();
            return back()->with('success', 'The accreditation status has been successfully renewed by the Head of the Study Program.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update the Head of Study Program status: ' . $e->getMessage()]);
        }
    }


    public function updateStatusKajur(Request $request, $id_akreditasi)
    {
        DB::beginTransaction();
        try {
            $akreditasi = tAkreditasi::findOrFail($id_akreditasi);
            $fileAkreditasi = tFileAkreditasi::where('akreditasi_id', $id_akreditasi)
                ->latest('created_at')->first();

            if ($fileAkreditasi->status_kaprodi !== 'Disetujui') {
                return back()->withErrors(['error' => 'Accreditation status has not been approved by the Head of Study Program.']);
            }
            $kajurId = auth()->user();
            if (!$kajurId) {
                return back()->with('error', 'Failed to retrieve data from logged-in users');
            }
            $fileAkreditasi->update([
                'status_kajur' => $request->status_kajur,
                'komentar_kajur' => $request->komentar_kajur,
                'kajur_id' => auth()->user()->user_id,
                'tanggal_waktu_kajur' => now(),
            ]);

            if ($request->status_kajur === 'Ditolak') {
                $akreditasi->update(['status' => 'revisi']);
                $fileAkreditasi->update(['statusFile' => 'Revisi']);
            }
            // dd($akreditasi, $fileAkreditasi, $kajurId);
            DB::commit();
            return back()->with('success', 'The accreditation status has been successfully updated by the Head of Department.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update the Head of Department status: ' . $e->getMessage()]);
        }
    }


    public function updateStatusKjm(Request $request, $id_akreditasi)
    {
        DB::beginTransaction();
        try {
            $akreditasi = tAkreditasi::findOrFail($id_akreditasi);
            $fileAkreditasi = tFileAkreditasi::where('akreditasi_id', $id_akreditasi)
                ->latest('created_at')->first();

            if ($fileAkreditasi->status_kajur !== 'Disetujui' && $fileAkreditasi->status_kaprodi !== 'Disetujui') {
                return back()->withErrors(['error' => 'Accreditation status has not yet been approved by the Head of Study Program and Head of Department.']);
            }

            $KjmID = auth()->user();
            if (!$KjmID) {
                return back()->with('error', 'Failed to retrieve KJM data from logged-in user');
            }

            $fileAkreditasi->update([
                'status_kjm' => $request->status_kjm,
                'komentar_kjm' => $request->komentar_kjm,
                'kjm_id' => auth()->user()->user_id,
                'tanggal_waktu_kjm' => now(),
            ]);

            if ($request->status_kjm === 'Ditolak') {
                $akreditasi->update(['status' => 'revisi']);
                $fileAkreditasi->update(['statusFile' => 'Revisi']);
            }

            DB::commit();
            return back()->with('success', 'Accreditation status successfully renewed by KJM.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update KJM status: ' . $e->getMessage()]);
        }
    }


    public function updateStatusDirekturUtama(Request $request, $id_akreditasi)
    {
        DB::beginTransaction();
        try {
            $akreditasi = tAkreditasi::findOrFail($id_akreditasi);
            $fileAkreditasi = tFileAkreditasi::where('akreditasi_id', $id_akreditasi)
                ->latest('created_at')->first();
            if ($fileAkreditasi->status_kjm !== 'Disetujui' && $fileAkreditasi->status_kajur !== 'Disetujui' && $fileAkreditasi->status_kaprodi !== 'Disetujui') {
                return back()->withErrors(['error' => 'Accreditation status has not been approved by the Head of Study Program, Head of Department, and KJM.']);
            }

            $IdDirekturUtama = auth()->user();
            if (!$IdDirekturUtama) {
                return back()->with('error', 'Failed to retrieve the direktur data from the logged-in user');
            }

            $fileAkreditasi->update([
                'status_direktur_utama' => $request->status_direktur_utama,
                'komentar_direktur_utama' => $request->komentar_direktur_utama,
                'direktur_utama_id' => auth()->user()->user_id,
                'tanggal_waktu_direktur_utama' => now(),
            ]);

            if ($request->status_kjm === 'Ditolak') {
                $akreditasi->update(['status' => 'revisi']);
                $fileAkreditasi->update(['statusFile' => 'Revisi']);
            } else if ($request->status_direktur_utama === 'Disetujui') {
                $akreditasi->update(['status' => 'selesai']);
                $fileAkreditasi->update(['statusFile' => 'Validation']);
            }

            DB::commit();
            return back()->with('success', 'The accreditation status was successfully renewed by the President Director.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to update the status of the President Director: ' . $e->getMessage()]);
        }
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
