<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name' => 'Admin',
            'last_name' => 'Master',
            'password' => bcrypt('admin'),
            'height' => 170,
            'weight' => 87,
            'sex' => 'male',
            'age' => 30,
            'objetivo' => 'hipertrofia',
            'role' => 'admin'
        ];

        User::updateOrCreate(
            ['email' => 'admin@synapsefit.com.br'], // critério de identificação
            $data
        );
    }
}
