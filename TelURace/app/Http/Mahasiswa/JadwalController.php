<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalCoaching;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jadwal = JadwalCoaching::where('userid', $user->id)
            ->orderBy('tanggalwaktu', 'asc')
            ->get();
        
        return view('mahasiswa.jadwal.index', compact('jadwal'));
    }
} 