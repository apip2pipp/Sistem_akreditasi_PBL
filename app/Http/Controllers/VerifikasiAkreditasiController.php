<?php

namespace App\Http\Controllers;

use App\Models\mKriteria;
use App\Models\tFileAkreditasi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VerifikasiAkreditasiController extends Controller
{
    public function list(Request $request, $slug)
    {
        $kriteria = mKriteria::where('route', $slug)->first();
        if (!$kriteria) {
            return abort(404);
        }
        $akreditasi = tFileAkreditasi::with(['akreditasi' => function ($query) {
            $query->select('id_akreditasi', 'status'); // Make sure to select only the necessary fields
        }])
            ->whereHas('akreditasi', function ($query) use ($kriteria) {
                $query->where('kriteria_id', $kriteria->kriteria_id);
            })
            ->select('akreditasi_id', 'id_file_akreditasi', 'file_akreditasi') // Select relevant fields from tFileAkreditasi
            ->get();

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
            'title' => 'Daftar' . ' ' . $kriteria->nama_kriteria,
            'list' => ['Home', $kriteria->nama_kriteria]
        ];

        $page = (object)[
            'title' => 'Daftar' . ' ' . $kriteria->nama_kriteria
        ];
        return view('akreditasi.index', compact('kriteria', 'breadcrumb', 'page'));
    }
}
