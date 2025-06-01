<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalCoaching;
use App\Models\Lomba;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JadwalCoachingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jadwals = JadwalCoaching::where('userid', $user->id)
                                ->orderBy('tanggal_waktu', 'desc')
                                ->get();
        
        $lombas = Lomba::where('status', 'aktif')->get();
        
        return view('mahasiswa.jadwal.index', compact('jadwals', 'lombas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lombaid' => 'required|exists:lombas,id',
            'jenis' => 'required|in:coaching,wawancara',
            'tanggal' => 'required|date|after:today',
            'waktu' => 'required',
        ]);

        // Combine date and time
        $tanggalWaktu = Carbon::parse($request->tanggal . ' ' . $request->waktu);

        // Check for schedule conflicts
        $existingSchedule = JadwalCoaching::where('tanggal_waktu', $tanggalWaktu)
            ->where('status', '!=', 'dibatalkan')
            ->first();

        if ($existingSchedule) {
            return back()->with('error', 'Jadwal bertabrakan dengan jadwal lain. Silakan pilih waktu yang berbeda.');
        }

        $jadwal = new JadwalCoaching();
        $jadwal->userid = Auth::id();
        $jadwal->lombaid = $request->lombaid;
        $jadwal->jenis = $request->jenis;
        $jadwal->tanggal_waktu = $tanggalWaktu;
        $jadwal->status = 'pending';
        $jadwal->save();

        return redirect()->route('mahasiswa.jadwal.index')
                        ->with('success', 'Jadwal berhasil diajukan dan menunggu persetujuan.');
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalCoaching::where('id', $id)
                               ->where('userid', Auth::id())
                               ->firstOrFail();

        if ($jadwal->status !== 'pending') {
            return back()->with('error', 'Hanya jadwal dengan status pending yang dapat diubah.');
        }

        $request->validate([
            'tanggal' => 'required|date|after:today',
            'waktu' => 'required',
        ]);

        // Combine date and time
        $tanggalWaktu = Carbon::parse($request->tanggal . ' ' . $request->waktu);

        // Check for schedule conflicts
        $existingSchedule = JadwalCoaching::where('tanggal_waktu', $tanggalWaktu)
            ->where('id', '!=', $id)
            ->where('status', '!=', 'dibatalkan')
            ->first();

        if ($existingSchedule) {
            return back()->with('error', 'Jadwal bertabrakan dengan jadwal lain. Silakan pilih waktu yang berbeda.');
        }

        $jadwal->tanggal_waktu = $tanggalWaktu;
        $jadwal->status = 'pending';
        $jadwal->save();

        return redirect()->route('mahasiswa.jadwal.index')
                        ->with('success', 'Jadwal berhasil diubah dan menunggu persetujuan ulang.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalCoaching::where('id', $id)
                               ->where('userid', Auth::id())
                               ->firstOrFail();

        if ($jadwal->status === 'disetujui') {
            $jadwal->status = 'dibatalkan';
            $jadwal->save();
            return redirect()->route('mahasiswa.jadwal.index')
                           ->with('success', 'Jadwal berhasil dibatalkan.');
        }

        $jadwal->delete();
        return redirect()->route('mahasiswa.jadwal.index')
                        ->with('success', 'Jadwal berhasil dihapus.');
    }
}
