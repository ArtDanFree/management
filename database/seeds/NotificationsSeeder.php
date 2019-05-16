<?php

use Illuminate\Database\Seeder;

class NotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Notification::create([
            'name' => 'Telegram'
        ]);
        \App\Models\Notification::create([
            'name' => 'Email'
        ]);
    }
}
