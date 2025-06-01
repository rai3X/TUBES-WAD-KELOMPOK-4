<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lomba;
use App\Models\Dokumen;
use App\Models\Mahasiswa;
use App\Models\PendaftaranLomba;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get competition statistics
        $totalLomba = Lomba::count();
        $activeLomba = Lomba::where('status', 'Aktif')->count();
        $totalPendaftar = PendaftaranLomba::count();
        
        // Get document statistics
        $totalDokumen = Dokumen::count();
        $dokumenMenunggu = Dokumen::where('statusVerifikasi', 'Menunggu')->count();
        $dokumenTerverifikasi = Dokumen::where('statusVerifikasi', 'Terverifikasi')->count();
        
        // Get recent competitions
        $recentLomba = Lomba::orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Get recent documents needing verification
        $recentDokumen = Dokumen::with('user')
            ->where('statusVerifikasi', 'Menunggu')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalLomba',
            'activeLomba',
            'totalPendaftar',
            'totalDokumen',
            'dokumenMenunggu',
            'dokumenTerverifikasi',
            'recentLomba',
            'recentDokumen'
        ));
    }
} 