<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalCoaching;
use App\Models\Lomba;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jadwals = JadwalCoaching::with('lomba')
            ->where('userid', $user->id)
            ->orderBy('tanggal_waktu', 'asc')
            ->get();
        
        $lombas = Lomba::where('status', 'Aktif')->get();
        
        return view('mahasiswa.jadwal.index', compact('jadwals', 'lombas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lombaid' => 'required|exists:lombas,id',
            'jenis' => 'required|in:coaching,wawancara',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required'
        ]);

        $tanggalWaktu = Carbon::parse($request->tanggal . ' ' . $request->waktu);

        // Check for existing schedule at the same time
        $existingSchedule = JadwalCoaching::where('tanggal_waktu', $tanggalWaktu)
            ->where('status', '!=', 'dibatalkan')
            ->first();

        if ($existingSchedule) {
            return redirect()->back()->with('error', 'Jadwal pada waktu tersebut sudah terisi.');
        }

        $jadwal = new JadwalCoaching();
        $jadwal->userid = Auth::id();
        $jadwal->lombaid = $request->lombaid;
        $jadwal->jenis = $request->jenis;
        $jadwal->tanggal_waktu = $tanggalWaktu;
        $jadwal->status = 'pending';
        $jadwal->save();

        return redirect()->route('mahasiswa.jadwal.index')->with('success', 'Jadwal berhasil diajukan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required'
        ]);

        $jadwal = JadwalCoaching::where('userid', Auth::id())->findOrFail($id);

        if ($jadwal->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya jadwal dengan status menunggu yang dapat diubah.');
        }

        $tanggalWaktu = Carbon::parse($request->tanggal . ' ' . $request->waktu);

        // Check for existing schedule at the same time
        $existingSchedule = JadwalCoaching::where('tanggal_waktu', $tanggalWaktu)
            ->where('id', '!=', $id)
            ->where('status', '!=', 'dibatalkan')
            ->first();

        if ($existingSchedule) {
            return redirect()->back()->with('error', 'Jadwal pada waktu tersebut sudah terisi.');
        }

        $jadwal->tanggal_waktu = $tanggalWaktu;
        $jadwal->save();

        return redirect()->route('mahasiswa.jadwal.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalCoaching::where('userid', Auth::id())->findOrFail($id);

        if ($jadwal->status === 'dibatalkan') {
            return redirect()->back()->with('error', 'Jadwal sudah dibatalkan.');
        }

        $jadwal->status = 'dibatalkan';
        $jadwal->save();

        return redirect()->route('mahasiswa.jadwal.index')->with('success', 'Jadwal berhasil dibatalkan.');
    }

    public function delete($id)
    {
        $jadwal = JadwalCoaching::where('userid', Auth::id())->findOrFail($id);

        if ($jadwal->status !== 'dibatalkan') {
            return redirect()->back()->with('error', 'Hanya jadwal yang sudah dibatalkan yang dapat dihapus permanen.');
        }

        try {
            $jadwal->delete();
            return redirect()->route('mahasiswa.jadwal.index')
                ->with('success', 'Jadwal berhasil dihapus permanen.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus jadwal.');
        }
    }
} 