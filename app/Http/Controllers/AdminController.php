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
        $admin = Admin::with('lokasi')->paginate(10);
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
}