<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Report::create([
                'user_id' => $user->id,
                'title' => 'Monthly Report - August 2024',
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth(),
                'file_path' => 'reports/monthly_report_august_2024.pdf',
            ]);
        }
    }
}
