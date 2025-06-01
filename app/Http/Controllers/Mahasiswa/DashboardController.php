<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lomba;
use App\Models\Dokumen;
use App\Models\JadwalCoaching;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // Get active competitions count
        $activeCompetitions = Lomba::where('status', 'Aktif')->count();

        // Get verified documents count
        $verifiedDocuments = Dokumen::where('userid', $user->id)
            ->where('statusVerifikasi', 'Terverifikasi')
            ->count();

        // Get upcoming coaching count
        $upcomingCoaching = JadwalCoaching::where('userid', $user->id)
            ->where('status', 'Terjadwal')
            ->where('tanggal_waktu', '>=', now())
            ->count();

        // Get total competitions
        $totalCompetitions = Lomba::count();

        // Get recent competitions
        $recentCompetitions = Lomba::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get upcoming schedules
        $upcomingSchedules = JadwalCoaching::where('userid', $user->id)
            ->where('tanggal_waktu', '>=', now())
            ->orderBy('tanggal_waktu', 'asc')
            ->take(5)
            ->get();

        return view('mahasiswa.dashboard', compact(
            'activeCompetitions',
            'verifiedDocuments',
            'upcomingCoaching',
            'totalCompetitions',
            'recentCompetitions',
            'upcomingSchedules'
        ));
    }
}
