<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserSubscription;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Verifica se já existe um usuário admin
        if (!User::where('email', 'admin@synapsefit.com')->exists()) {
            User::create([
                'name' => 'Administrador',
                'last_name' => 'Master',
                'height' => '1.70',
                'weight' => '70',
                'sex' => 'male',
                'age' => '32',
                'objetivo' => 'hipertrofia',
                'email' => 'admin@synapsefit.com',
                'password' => '$2a$12$ZC4K6UzfrIiqiPi6qrgft.zPBiLNa5LEiVDPMQAPjHJcmaNH0EyES',
                'role' => 'admin',
            ]);
        }
    }
}
