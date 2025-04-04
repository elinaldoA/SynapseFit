<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'last_name' => 'Master',
            'email' => 'admin@snapsefit.com.br',
            'password' => Hash::make('admin'),
            'height' => '170',
            'weight' => '87',
            'sex' => 'male',
            'age' => '30',
            'objetivo' => 'hipertrofia',
            'role' => 'admin'
        ]);
    }
}
