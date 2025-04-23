<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserSubscription;

class AdminSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Verifica se o usuário admin existe
        $adminUser = \App\Models\User::where('email', 'admin@synapsefit.com')->first();

        // Se o usuário admin existir, cria a assinatura
        if ($adminUser) {
            UserSubscription::create([
                'user_id' => $adminUser->id,
                'plan_id' => 5,
                'start_date' => now(), // Data de início
                'end_date' => now()->addYear(), // Data de término (1 ano)
                'payment_method' => 'Pix',
                'payment_status' => 'Pago',
                'is_active' => true,
            ]);
        }
    }
}
