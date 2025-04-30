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
        $adminUser = \App\Models\User::where('email', 'admin@synapsefit.com')->first();

        if ($adminUser) {
            UserSubscription::create([
                'user_id' => $adminUser->id,
                'plan_id' => 5,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'payment_method' => 'Pix',
                'payment_status' => 'Pago',
                'is_active' => true,
            ]);
        }
    }
}
