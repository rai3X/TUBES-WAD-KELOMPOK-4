<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lomba;
use App\Models\PendaftaranLomba;
use Illuminate\Support\Facades\Auth;

class PendaftaranLombaController extends Controller
{
    public function show($id)
    {
        $lomba = Lomba::findOrFail($id);
        return view('mahasiswa.lomba.daftar', compact('lomba'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'persetujuan' => 'required|accepted',
        ]);

        $lomba = Lomba::findOrFail($id);

        // Check if user has already registered for this competition
        $existingRegistration = PendaftaranLomba::where('user_id', Auth::id())
            ->where('lomba_id', $lomba->id)
            ->first();

        if ($existingRegistration) {
            return redirect()->back()->with('error', 'Anda sudah terdaftar dalam lomba ini.');
        }

        // Create new registration
        $pendaftaran = new PendaftaranLomba();
        $pendaftaran->user_id = Auth::id();
        $pendaftaran->lomba_id = $lomba->id;
        $pendaftaran->status = 'pending';
        $pendaftaran->save();

        return redirect()->route('mahasiswa.lomba')->with('success', 'Pendaftaran lomba berhasil diajukan.');
    }

    public function cancel($id)
    {
        $pendaftaran = PendaftaranLomba::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($pendaftaran->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya pendaftaran dengan status menunggu yang dapat dibatalkan.');
        }

        $pendaftaran->status = 'dibatalkan';
        $pendaftaran->catatan = 'Dibatalkan oleh mahasiswa';
        $pendaftaran->save();

        return redirect()->route('mahasiswa.lomba')->with('success', 'Pendaftaran lomba berhasil dibatalkan.');
    }

    public function detail($id)
    {
        $pendaftaran = PendaftaranLomba::with(['lomba', 'user'])
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('mahasiswa.lomba.detail', compact('pendaftaran'));
    }

    public function withdraw($id)
    {
        $pendaftaran = PendaftaranLomba::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($pendaftaran->status === 'ditolak') {
            return redirect()->back()->with('error', 'Tidak dapat mengundurkan diri dari lomba yang sudah ditolak.');
        }

        $pendaftaran->status = 'mengundurkan_diri';
        $pendaftaran->catatan = 'Mahasiswa mengundurkan diri dari lomba';
        $pendaftaran->save();

        return redirect()->route('mahasiswa.lomba')->with('success', 'Anda telah berhasil mengundurkan diri dari lomba.');
    }

    public function destroy($id)
    {
        $pendaftaran = PendaftaranLomba::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        // Allow deletion for both rejected and cancelled registrations
        if (!in_array($pendaftaran->status, ['ditolak', 'dibatalkan'])) {
            return redirect()->back()->with('error', 'Hanya pendaftaran yang ditolak atau dibatalkan yang dapat dihapus.');
        }

        try {
            $pendaftaran->delete();
            return redirect()->route('mahasiswa.lomba')
                ->with('success', 'Pendaftaran lomba berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus pendaftaran lomba.');
        }
    }
}
