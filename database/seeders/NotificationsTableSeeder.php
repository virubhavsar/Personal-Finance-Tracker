<?php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'type' => 'Budget Alert',
                'message' => 'You have exceeded your budget for this category.',
                'is_read' => false,
            ]);

            Notification::create([
                'user_id' => $user->id,
                'type' => 'Payment Reminder',
                'message' => 'Reminder: Your subscription payment is due soon.',
                'is_read' => false,
            ]);
        }
    }
}
