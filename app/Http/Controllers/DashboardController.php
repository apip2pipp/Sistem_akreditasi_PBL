<?php

namespace App\Http\Controllers;

use App\Models\mDosen;
use App\Models\mKriteria;
use App\Models\mLevel;
use App\Models\mUser;
use App\Models\tAkreditasi;
use App\Models\tPenelitianDosen;
use App\Models\tPermissionKriteriaUser;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'list' => ['Home', 'Dashboard']
        ];
        $activeMenu = 'dashboard';


        $dataUser = mUser::count();
        $dataLevel = mLevel::count();
        $totalCriteria = mKriteria::count();
        $totalPermission = tPermissionKriteriaUser::count();
        $dataPenelitian = tPenelitianDosen::count();
        $dataAkreditasikoordinator = tAkreditasi::count();
        return view('dashboard.index', compact('breadcrumb', 'activeMenu','dataUser','dataLevel','totalCriteria','totalPermission','dataPenelitian'));
    }
}