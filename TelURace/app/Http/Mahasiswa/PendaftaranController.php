<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftaranLomba;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    // Menampilkan semua pendaftaran lomba mahasiswa yang sedang login
    public function index()
    {
        $user = Auth::user();

        $pendaftarans = PendaftaranLomba::with('lomba')
            ->where('userid', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mahasiswa.pendaftaran.index', compact('pendaftarans'));
    }

    // Menampilkan detail dari salah satu pendaftaran
    public function show($id)
    {
        $pendaftaran = PendaftaranLomba::with('lomba', 'mahasiswa')
            ->where('userid', Auth::id())
            ->findOrFail($id);

        return view('mahasiswa.pendaftaran.show', compact('pendaftaran'));
    }

    // Fungsi untuk membatalkan pendaftaran (opsional)
    public function cancel($id)
    {
        $pendaftaran = PendaftaranLomba::where('userid', Auth::id())
            ->where('status', 'Pending')
            ->findOrFail($id);

        $pendaftaran->delete();

        return redirect()->route('mahasiswa.pendaftaran.index')->with('success', 'Pendaftaran berhasil dibatalkan.');
    }
}
