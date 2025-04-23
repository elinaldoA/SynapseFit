<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PlanSeeder::class);
        $this->call(AdminUserSeeder::class);
        $this->call(AdminSubscriptionSeeder::class);
        $this->call(ExerciseSeeder::class);
        $this->call(WorkoutSeeder::class);
    }
}
