<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            Category::create([
                'user_id' => $user->id,
                'name' => 'Groceries',
                'type' => 'expense',
            ]);

            Category::create([
                'user_id' => $user->id,
                'name' => 'Salary',
                'type' => 'income',
            ]);
        }
    }
}
