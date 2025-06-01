<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lomba;
use App\Models\PendaftaranLomba;
use Illuminate\Support\Facades\Auth;

class LombaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // Get competitions registered by the student
        $registeredCompetitions = PendaftaranLomba::where('userid', $user->id)
            ->with('lomba')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get available competitions
        $availableCompetitions = Lomba::where('status', 'Aktif')
            ->whereDoesntHave('pendaftaran', function($query) use ($user) {
                $query->where('userid', $user->id);
            })
            ->get();

        return view('mahasiswa.lomba.index', compact('registeredCompetitions', 'availableCompetitions'));
    }
} 