<?php

namespace App\Http\Controllers;

use App\Models\mDirut;
use App\Models\mDosen;
use App\Models\mKajur;
use App\Models\mKaprodi;
use App\Models\mKjm;
use App\Models\mKoordinator;
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
            $data = mUser::with('level')->select('user_id', 'username', 'email', 'name', 'level_id', 'nidn');
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
            'title' => 'User List',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'List of users registered in the system'
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
            'level_id' => 'required|exists:m_levels,level_id',
            'nidn' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $UserID = mUser::create($data);


        return response()->json([
            'message' => 'User data successfully saved'
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
            'name' => 'required|string|max:100',
            'email' => "required|email|unique:m_users,email,$id,user_id",
            'password' => 'nullable|string|min:6|confirmed',
            'level_id' => 'required|exists:m_levels,level_id',
            'nidn' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed!',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $mUser = mUser::find($id);

        $data = $request->only(['username', 'email', 'name', 'level_id', 'nidn']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $mUser->update($data);

        return response()->json([
            'message' => 'User data successfully updated'
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
                    'message' => 'Data not found'
                ], Response::HTTP_NOT_FOUND);
            }



            // Jika tidak ada relasi, hapus user
            $mUser->delete();

            return response()->json([
                'message' => 'Data successfully deleted!'
            ], Response::HTTP_OK);
        }

        return redirect('/dashboard');
    }
}
