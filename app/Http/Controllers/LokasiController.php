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
}