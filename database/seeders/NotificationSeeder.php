<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = User::where('is_admin', false)->get();
        $types = ['marketing', 'invoices', 'system'];

        DB::transaction(function () use ($users, $types) {
            for ($i = 0; $i < 10; $i++) {
                // Randomly decide if this notification is for all users or a single user
                $notificationFor = rand(0, 1) == 1 ? 'all' : $users->random()->id;

                $notification = Notification::create([
                    'type' => $types[array_rand($types)],
                    'text' => fake()->realText($maxNbChars = 50, $indexSize = 2),
                    'expiration' => Carbon::now()->addDays(rand(1, 30)), // Future expiration date
                    'notification_for' => $notificationFor, // Set notification_for
                ]);

                if ($notificationFor === 'all') {
                    foreach ($users as $user) {
                        DB::table('notification_user')->insert([
                            'notification_id' => $notification->id,
                            'user_id' => $user->id,
                            'is_read' => false,
                        ]);
                    }
                } else {
                    DB::table('notification_user')->insert([
                        'notification_id' => $notification->id,
                        'user_id' => $notificationFor,
                        'is_read' => false,
                    ]);
                }
            }
        });
    }
}
