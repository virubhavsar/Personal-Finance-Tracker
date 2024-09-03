<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\RecurringTransaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecurringTransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();

        foreach ($users as $user) {
            foreach ($categories as $category) {
                RecurringTransaction::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'amount' => rand(50, 200),
                    'type' => $category->type,
                    'interval' => 'monthly',
                    'start_date' => now()->startOfMonth(),
                    'end_date' => now()->addYear(),
                    'description' => 'Recurring transaction description',
                ]);
            }
        }
    }
}
