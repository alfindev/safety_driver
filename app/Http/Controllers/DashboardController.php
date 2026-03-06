<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\CheckSheet;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function index()
{
    $stats = [
        'active_drivers'  => User::where('role','driver')->where('status','active')->count(),
        'total_drivers'   => User::where('role','driver')->count(),
        'today_reports'   => CheckSheet::whereDate('check_date', today())->count(),
        'draft_reports'   => CheckSheet::where('overall_status','draft')->count(),
        'nok_today'       => CheckSheet::whereDate('check_date', today())
                               ->where('overall_status','nok')->count(),
        'expiring_sim'    => User::where('role','driver')
                               ->whereNotNull('sim_expires_at')
                               ->where('sim_expires_at','<=', now()->addDays(30))
                               ->count(),
    ];

    $recentReports = CheckSheet::with(['driver', 'vehicle'])
        ->latest()
        ->take(10)
        ->get();

    return view('dashboard', compact('stats', 'recentReports'));
}

}
