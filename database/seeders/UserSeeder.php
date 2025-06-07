<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = 'profile_pictures/L2jPwffRU7yCJqtrECknOn8trtdvLrI4Ym5AkkM2.png';

        User::insert([
            [
            'role_id' => 1,
            'name' => 'Owner Koka',
            'email' => 'ownerkoka@gmail.com',
            'password' => Hash::make('0987654321'), // Meng-hash password
            'id_lokasi' => null,
            'no_hp' => '081234567890',
            'foto_profile' => $filePath,
            'alamat' => 'Kota Jambi',
            ]
        ]);
    }
}
