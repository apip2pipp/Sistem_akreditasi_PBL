<?php

namespace App\Http\Controllers;

use App\Models\mUser;
use App\Models\mLevel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class MUserController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = mUser::with('level')->select('user_id', 'username', 'email', 'name', 'level_id');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('level_nama', function ($row) {
                    return $row->level->level_nama ?? '-';
                })
                ->make(true);
        }
    }

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Pengguna',
            'list' => ['Home', 'Pengguna']
        ];

        $page = (object) [
            'title' => 'Daftar pengguna yang terdaftar dalam sistem'
        ];

        return view('users.index', compact('breadcrumb', 'page'));
    }

    public function create()
    {
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('users.create', compact('levels'));
    }

    public function store(Request $request)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            redirect('/dashboard');
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:m_users,username|min:3',
            'email' => 'required|email|unique:m_users,email',
            'name' => 'required|string|max:100',
            'password' => 'required|string|min:6|confirmed',
            'level_id' => 'required|exists:m_levels,level_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        mUser::create($data);

        return response()->json([
            'message' => 'Data pengguna berhasil disimpan'
        ], Response::HTTP_OK);
    }

    public function show(mUser $mUser)
    {
        return view('users.show', compact('mUser'));
    }

    public function edit($id)
    {
        $mUser = mUser::find($id);
        $levels = mLevel::select('level_id', 'level_nama')->get();
        return view('users.edit', compact('mUser', 'levels'));
    }

    public function update(Request $request, string $id)
    {
        if (!$request->ajax() && !$request->wantsJson()) {
            return redirect('/dashboard');
        }

        $validator = Validator::make($request->all(), [
            'username' => "required|string|min:3|unique:m_users,username,$id,user_id",
            'email' => "required|email|unique:m_users,email,$id,user_id",
            'name' => 'required|string|max:100',
            'level_id' => 'required|exists:m_levels,level_id',
            'password' => 'nullable|string|min:6|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $mUser = mUser::find($id);
        $data = $request->only(['username', 'email', 'name', 'level_id']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $mUser->update($data);

        return response()->json([
            'message' => 'Data berhasil diupdate'
        ], Response::HTTP_OK);
    }

    public function confirm(string $id)
    {
        $mUser = mUser::find($id);
        return view('users.confirm-delete', compact('mUser'));
    }

    public function destroy(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $mUser = mUser::find($id);
            if (!$mUser) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], Response::HTTP_NOT_FOUND);
            }

            $mUser->delete();

            return response()->json([
                'message' => 'Data berhasil dihapus!'
            ], Response::HTTP_OK);
        }

        return redirect('/dashboard');
    }
}
