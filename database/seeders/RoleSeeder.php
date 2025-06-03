<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['supervisor', 'admin'];

        foreach($roles as $item) {
            Role::create([
                'role_name' => $item
            ]);
        }
    }
}
