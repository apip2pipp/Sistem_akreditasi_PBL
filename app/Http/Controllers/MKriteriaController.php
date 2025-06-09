<?php

namespace App\Http\Controllers;

use App\Models\mKriteria;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class MKriteriaController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = mKriteria::select('kriteria_id', 'nama_kriteria', 'route');
            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }
    }

    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'List of Criteria',
            'list' => ['Home', 'Kriteria']
        ];

        $page = (object)[
            'title' => 'List of criteria registered in the system'
        ];

        return view('kriterias.index', compact('breadcrumb', 'page'));
    }

    public function create()
    {
        return view('kriterias.create');
    }

    public function store(Request $request)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $validator = Validator::make($request->all(), [
            'nama_kriteria' => 'required|string|max:255',
            'route' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        mKriteria::create($request->only('nama_kriteria', 'route'));

        return response()->json([
            'message' => 'Criteria data successfully saved!'
        ], Response::HTTP_OK);
    }

    public function edit($id)
    {
        $mKriteria = mKriteria::find($id);
        return view('kriterias.edit', compact('mKriteria'));
    }

    public function update(Request $request, $id)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $mKriteria = mKriteria::find($id);
        if (!$mKriteria) {
            return response()->json([
                'message' => 'Criteria data not found!'
            ], Response::HTTP_NOT_FOUND);
        }

        $validator = Validator::make($request->all(), [
            'nama_kriteria' => 'required|string|max:255',
            'route' => 'nullable|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $mKriteria->update($request->only('nama_kriteria', 'route'));

        return response()->json([
            'message' => 'Criteria data successfully updated'
        ], Response::HTTP_OK);
    }

    public function confirm(string $id)
    {
        $mKriteria = mKriteria::find($id);
        return view('kriterias.confirm-delete', compact('mKriteria'));
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mKriteria = mKriteria::find($id);
            if (!$mKriteria) {
                return response()->json([
                    'message' => 'Criteria data not found'
                ], Response::HTTP_NOT_FOUND);
            }

            $mKriteria->delete();

            return response()->json([
                'message' => 'Criteria data successfully deleted!'
            ], Response::HTTP_OK);
        }

        return redirect('/dashboard');
    }
}
