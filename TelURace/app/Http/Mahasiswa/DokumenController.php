<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dokumen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DokumenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dokumen = Dokumen::where('userid', $user->id)
                         ->orderBy('created_at', 'desc')
                         ->get();
        
        return view('mahasiswa.dokumen.index', compact('dokumen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_dokumen' => 'required|in:proposal,surat_tugas,sertifikat',
            'file_dokumen' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB max
        ]);

        $file = $request->file('file_dokumen');
        $fileName = time() . '_' . Str::slug($request->jenis_dokumen) . '.' . $file->getClientOriginalExtension();
        
        // Store file in storage/app/public/dokumen
        $path = $file->storeAs('public/dokumen', $fileName);

        $dokumen = new Dokumen();
        $dokumen->userid = Auth::id();
        $dokumen->namaFile = $fileName;
        $dokumen->jenisdokumen = $request->jenis_dokumen;
        $dokumen->filepath = $path;
        $dokumen->statusVerifikasi = 'menunggu';
        // lombaid is now nullable, so we don't need to set it
        $dokumen->save();

        return redirect()->route('mahasiswa.dokumen.index')
                        ->with('success', 'Dokumen berhasil diupload dan menunggu verifikasi.');
    }

    public function download($id)
    {
        $dokumen = Dokumen::where('dokumenid', $id)
                         ->where('userid', Auth::id())
                         ->firstOrFail();

        return Storage::download($dokumen->filepath);
    }

    public function destroy($id)
    {
        $dokumen = Dokumen::where('dokumenid', $id)
                         ->where('userid', Auth::id())
                         ->firstOrFail();

        // Delete file from storage
        Storage::delete($dokumen->filepath);
        
        // Delete record from database
        $dokumen->delete();

        return redirect()->route('mahasiswa.dokumen.index')
                        ->with('success', 'Dokumen berhasil dihapus.');
    }
} 