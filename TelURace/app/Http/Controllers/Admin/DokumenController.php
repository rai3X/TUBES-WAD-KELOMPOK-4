<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index()
    {
        $dokumen = Dokumen::with(['user', 'lomba'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.dokumen.index', compact('dokumen'));
    }

    public function show(Dokumen $dokumen)
    {
        return view('admin.dokumen.show', compact('dokumen'));
    }

    public function verify(Request $request, Dokumen $dokumen)
    {
        try {
            $dokumen->update([
                'statusVerifikasi' => 'terverifikasi',
                'catatan' => $request->catatan ?? 'Dokumen telah diverifikasi dan dinyatakan valid.'
            ]);

            return redirect()->back()->with('success', 'Dokumen berhasil diverifikasi.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memverifikasi dokumen.');
        }
    }

    public function revision(Request $request, Dokumen $dokumen)
    {
        $request->validate([
            'catatan' => 'required|string|min:10',
        ], [
            'catatan.required' => 'Catatan revisi wajib diisi.',
            'catatan.min' => 'Catatan revisi minimal 10 karakter.'
        ]);

        try {
            $dokumen->update([
                'statusVerifikasi' => 'revisi',
                'catatan' => $request->catatan
            ]);

            return redirect()->back()->with('success', 'Permintaan revisi dokumen berhasil dikirim.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim permintaan revisi.');
        }
    }

    public function reject(Request $request, Dokumen $dokumen)
    {
        $request->validate([
            'catatan' => 'required|string|min:10',
        ], [
            'catatan.required' => 'Alasan penolakan wajib diisi.',
            'catatan.min' => 'Alasan penolakan minimal 10 karakter.'
        ]);

        try {
            $dokumen->update([
                'statusVerifikasi' => 'ditolak',
                'catatan' => $request->catatan
            ]);

            return redirect()->back()->with('success', 'Dokumen berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak dokumen.');
        }
    }

    public function destroy(Dokumen $dokumen)
    {
        try {
            // Delete the file from storage if it exists
            if ($dokumen->filepath && Storage::exists($dokumen->filepath)) {
                Storage::delete($dokumen->filepath);
            }

            $dokumen->delete();
            return redirect()->route('admin.dokumen.index')
                ->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus dokumen.');
        }
    }
} 