<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalCoaching;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = JadwalCoaching::with(['user', 'lomba'])
            ->orderBy('tanggal_waktu', 'asc')
            ->get();
        
        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function approve(Request $request, JadwalCoaching $jadwal)
    {
        try {
            $jadwal->update([
                'status' => 'disetujui',
                'catatan' => $request->catatan ?? 'Jadwal telah disetujui.'
            ]);

            return redirect()->back()->with('success', 'Jadwal berhasil disetujui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui jadwal.');
        }
    }

    public function reject(Request $request, JadwalCoaching $jadwal)
    {
        $request->validate([
            'catatan' => 'required|string|min:10',
        ], [
            'catatan.required' => 'Alasan penolakan wajib diisi.',
            'catatan.min' => 'Alasan penolakan minimal 10 karakter.'
        ]);

        try {
            $jadwal->update([
                'status' => 'ditolak',
                'catatan' => $request->catatan
            ]);

            return redirect()->back()->with('success', 'Jadwal berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak jadwal.');
        }
    }

    public function destroy(JadwalCoaching $jadwal)
    {
        try {
            $jadwal->delete();
            return redirect()->route('admin.jadwal.index')
                ->with('success', 'Jadwal berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus jadwal.');
        }
    }
} 