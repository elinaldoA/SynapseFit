<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::create([
            'name' => 'Free Trial',
            'description' => 'Acesso completo por 7 dias',
            'price' => 0.00,
            'duration_in_days' => 7,
        ]);
        Plan::create([
            'name' => 'Mensal',
            'description' => 'Acesso completo por 30 dias',
            'price' => 39.90,
            'duration_in_days' => 30,
        ]);

        Plan::create([
            'name' => 'Trimestral',
            'description' => 'Acesso completo por 90 dias com desconto',
            'price' => 99.90,
            'duration_in_days' => 90,
        ]);

        Plan::create([
            'name' => 'Anual',
            'description' => 'Plano anual com melhor custo-benefício',
            'price' => 299.90,
            'duration_in_days' => 365,
        ]);
    }
}
