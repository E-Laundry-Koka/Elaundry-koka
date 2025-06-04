<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
        ]);

        // Simpan lokasi
        Lokasi::create($validated);

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Lokasi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $lokasi = Lokasi::findOrFail($id);

        $validated = $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:255',
            'kode_pos' => 'nullable|string|max:10',
        ]);

        $lokasi->update([
            'nama_lokasi' => $validated['nama_lokasi'],
            'alamat' => $validated['alamat'],
            'kota' => $validated['kota'],
            'kode_pos' => $validated['kode_pos'],
        ]);

        return redirect()->back()->with('success', 'Lokasi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $lokasi = Lokasi::findOrFail($id);
            $lokasi->delete();
            
            return redirect()->back()->with('success', 'Lokasi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus Lokasi: ' . $e->getMessage());
        }
    }
}