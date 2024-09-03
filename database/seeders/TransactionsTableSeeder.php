<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
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
                Transaction::create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'recurring_transaction_id' => '',
                    'amount' => rand(50, 500),
                    'type' => $category->type,
                    'date' => now()->subDays(rand(1, 30)),
                    'description' => 'Sample transaction description',
                ]);
            }
        }
    }
}
