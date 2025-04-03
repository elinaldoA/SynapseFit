<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Elinaldo',
            'last_name' => 'Agostinho',
            'email' => 'elinaldoagostinho@outlook.com',
            'password' => bcrypt('admin'),
            'height' => '170',
            'weight' => '87',
            'sex' => 'male',
            'age' => '30',
            'objetivo' => 'hipertrofia',
            'role' => 'admin',
        ]);
    }
}
