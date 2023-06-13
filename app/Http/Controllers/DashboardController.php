<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $total_user = \App\Models\User::where('status', 1)
            ->count();
        return view('admin.dashboard.admin_dashboard', compact('total_user'));
    }
}