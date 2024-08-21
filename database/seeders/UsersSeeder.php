<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin123', 
        ]);
        User::create([
            'name' => 'Suwandi',
            'email' => 'suwandi@gmail.com',
            'jabatan' => 'sekdes',
            'password' => '123', 
        ]);
        User::create([
            'name' => 'Widodo',
            'email' => 'widodo@gmail.com',
            'jabatan' => 'kepala_desa',
            'password' => '123', 
        ]);
    }
}
