<?php

namespace Database\Seeders;

use App\Models\SavingsGoal;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SavingsGoalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            SavingsGoal::create([
                'user_id' => $user->id,
                'name' => 'Vacation Fund',
                'target_amount' => 2000,
                'current_amount' => rand(500, 1500),
                'deadline' => now()->addMonths(6),
            ]);

            SavingsGoal::create([
                'user_id' => $user->id,
                'name' => 'New Car',
                'target_amount' => 15000,
                'current_amount' => rand(3000, 12000),
                'deadline' => now()->addYear(),
            ]);
        }
    }
}
