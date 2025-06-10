<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'id_lokasi' => 'required|exists:lokasi,id',
            'no_hp' => 'required|string|min:12|max:13',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alamat' => 'required|max:255',
        ]);

        if ($request->hasFile('foto_profile')) {
            $file = $request->file('foto_profile');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('img');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $validated['foto_profile'] = 'img/' . $filename;
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
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($admin->id)
            ],
            'password' => 'nullable|string|min:8',
            'role_id' => 'required|exists:roles,id',
            'id_lokasi' => 'required|exists:lokasi,id',
            'no_hp' => 'required|string|min:12|max:13',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alamat' => 'required|max:255',
        ]);

        // Jika ada foto baru, upload dan simpan path
        if ($request->hasFile('foto_profile')) {
            $file = $request->file('foto_profile');
            $filename = uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('img');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $validated['foto_profile'] = 'img/' . $filename;
        } else {
            $validated['foto_profile'] = $admin->foto_profile;
        }

        // Jika password tidak diisi, hapus dari array agar tidak diupdate
        if (!$request->filled('password')) {
            unset($validated['password']);
        } else {
            // Jika password diisi, hash dulu sebelum disimpan
            $validated['password'] = bcrypt($validated['password']);
        }

        // Jika email tidak diisi, hapus dari array agar tidak diupdate
        if (!$request->filled('email') || $request->input('email') === $admin->email) {
            unset($validated['email']);
        } 

        $admin->update($validated);

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