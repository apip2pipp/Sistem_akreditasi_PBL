<?php

namespace App\Http\Controllers;

use App\Models\mDosen;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Welcome',
            'list' => ['Home', 'Welcome']
        ];
        $activeMenu = 'dashboard';


        return view('dashboard.index', compact('breadcrumb', 'activeMenu', ));
    }
}

