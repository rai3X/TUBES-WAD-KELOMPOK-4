<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LombaController extends Controller
{
    public function index()
    {
        $lomba = Lomba::orderBy('created_at', 'desc')->get();
        return view('admin.lomba.index', compact('lomba'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lomba' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'tingkat' => 'required|in:Universitas,Regional,Nasional,Internasional',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Aktif,Tidak Aktif'
        ], [
            'nama_lomba.required' => 'Nama lomba wajib diisi.',
            'penyelenggara.required' => 'Penyelenggara wajib diisi.',
            'tingkat.required' => 'Tingkat lomba wajib diisi.',
            'tingkat.in' => 'Tingkat lomba tidak valid.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'status.required' => 'Status lomba wajib diisi.',
            'status.in' => 'Status lomba tidak valid.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan. Silakan periksa form kembali.');
        }

        try {
            Lomba::create($request->all());
            return redirect()->route('admin.lomba.index')
                ->with('success', 'Lomba berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan lomba.')
                ->withInput();
        }
    }

    public function update(Request $request, Lomba $lomba)
    {
        $validator = Validator::make($request->all(), [
            'nama_lomba' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'tingkat' => 'required|in:Universitas,Regional,Nasional,Internasional',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Aktif,Tidak Aktif'
        ], [
            'nama_lomba.required' => 'Nama lomba wajib diisi.',
            'penyelenggara.required' => 'Penyelenggara wajib diisi.',
            'tingkat.required' => 'Tingkat lomba wajib diisi.',
            'tingkat.in' => 'Tingkat lomba tidak valid.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'status.required' => 'Status lomba wajib diisi.',
            'status.in' => 'Status lomba tidak valid.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan. Silakan periksa form kembali.');
        }

        try {
            $lomba->update($request->all());
            return redirect()->route('admin.lomba.index')
                ->with('success', 'Data lomba berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui data lomba.')
                ->withInput();
        }
    }

    public function destroy(Lomba $lomba)
    {
        try {
            // Check if there are any related records
            if ($lomba->dokumen()->exists() || $lomba->pendaftaran()->exists()) {
                return redirect()->back()
                    ->with('error', 'Lomba tidak dapat dihapus karena masih memiliki dokumen atau pendaftaran terkait.');
            }

            $lomba->delete();
            return redirect()->route('admin.lomba.index')
                ->with('success', 'Lomba berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus lomba.');
        }
    }
} 