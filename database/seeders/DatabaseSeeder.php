<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Admin User',
            'username' => 'admin', // Pastikan kolom ini ada di tabel users
            'email' => 'admin@example.com',
            'isAdmin' => true,
            'password' => Hash::make('password'), // Ganti dengan password yang diinginkan
        ]);

        User::create([
            'name' => 'Employee User',
            'username' => 'employee', // Pastikan kolom ini ada di tabel users
            'email' => 'employee@example.com',
            'password' => Hash::make('password'), // Ganti dengan password yang diinginkan
        ]);
    }
}
