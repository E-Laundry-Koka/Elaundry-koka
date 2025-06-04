<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Lokasi;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
        $admin = User::with(['lokasi', 'role'])->where('role_id', '2')->paginate(10);
        $roles = Role::all();
        $lokasiList = Lokasi::all(); // Changed variable name
        $totaladmin = $admin->total();
        $totalLokasi = Lokasi::count();
        
        return view('admin.listAdmin', compact('roles','admin', 'totaladmin', 'lokasiList', 'totalLokasi'));
    }


    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'id_lokasi' => 'required|exists:lokasi,id',
            'no_hp' => 'required|string|min:12|max:13',
            'foto_profile' => 'required',
            'alamat' => 'required|max:255',
        ]);

        if ($request->hasFile('foto_profile')) {
            $path = $request->file('foto_profile')->store('profile_pictures', 'public');
            $validated['foto_profile'] = $path;
        }

        // Enkripsi password sebelum disimpan
        $validated['password'] = Hash::make($validated['password']);

        // Simpan user baru
        User::create($validated);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.management')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admin,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'id_lokasi' => 'required|exists:lokasi,id',
            'no_hp' => 'required|string|min:12|max:13',
            'foto_profile' => 'string',
            'alamat' => 'required|max:255',
        ]);

        // Jika ada foto baru, upload dan simpan path
        if ($request->hasFile('foto_profile')) {
            // Simpan foto baru
            $path = $request->file('foto_profile')->store('profile_pictures', 'public');
            $validated['foto_profile'] = $path;
        } else {
            // Jika tidak ada foto baru, gunakan foto lama
            $validated['foto_profile'] = $admin->foto_profile;
        }

        $admin->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role_id' => $validated['role_id'],
            'id_lokasi' => $validated['id_lokasi'],
            'no_hp' => $validated['no_hp'],
            'foto_profile' => $validated['foto_profile'],
            'alamat' => $validated['alamat'],
        ]);

        return redirect()->back()->with('success', 'Admin berhasil diperbarui!');
    }

    public function destroy($id)
    {
        try {
            $admin = User::findOrFail($id);
            $admin->delete();
            
            return redirect()->back()->with('success', 'Admin berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus Admin: ' . $e->getMessage());
        }
    }
}