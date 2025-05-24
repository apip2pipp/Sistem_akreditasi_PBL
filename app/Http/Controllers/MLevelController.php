<?php

namespace App\Http\Controllers;

use App\Models\mLevel;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class MLevelController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = mLevel::selectRaw('level_id, level_kode, level_nama');
            // dd($data);
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
        $breadcrumb = (object) [
            'title' => 'Daftar Level Pengguna',
            'list' => ['Home', 'Level']
        ];

        $page = (object) [
            'title' => 'Daftar level pengguna yang terdaftar dalam sistem'
        ];
        return view('levels.index', compact('breadcrumb', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('levels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            redirect('/dashboard');
        }
        $validator = Validator::make($request->all(), [
            'level_kode' => "required|string|min:3|unique:m_levels,level_kode",
            'level_nama' => 'required|string|max:100|unique:m_levels,level_nama'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }
        mLevel::create($request->all());

        return response()->json([
            'message' => 'Data level berhasil disimpan'
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(mLevel $mLevel)
    {
        return view('levels.show', compact('mLevel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mLevel = mLevel::find($id);
        return view('levels.edit', compact('mLevel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $validator = Validator::make($request->all(), [
            'level_kode' => "required|string|min:3|unique:m_levels,level_kode,$id,level_id",
            'level_nama' => 'required|string|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $mLevel = mLevel::find($id);
        $mLevel->update($request->all());
        return response()->json([
            'message' => 'Data berhasil diupdate'
        ], Response::HTTP_OK);
    }

    public function confirm(string $id)
    {
        $mLevel = mLevel::find($id);
        return view('levels.confirm-delete', compact('mLevel'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mLevel = mLevel::find($id);
            if (!$mLevel) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], Response::HTTP_NOT_FOUND);
            }
            $mLevel->delete();
            return response()->json([
                'message' => 'Data berhasil dihapus!'
            ], Response::HTTP_OK);
        }
        return redirect('/dashboard');
    }
}
