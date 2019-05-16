<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = \App\Models\User::create([
            'email' => 'admin@admin.ru',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
            'role_id' => 1
        ]);
        $lead = \App\Models\User::create([
            'email' => 'underwriter@underwriter.ru',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
            'role_id' => 2,
            'first_name' => 'underwriter',
            'last_name' => 'underwriter',
            'surname' => 'underwriter',
            'telegram' => '1',
        ]);
        $manager = \App\Models\User::create([
            'email' => 'lead@lead.ru',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
            'role_id' => 3,
            'commission' => 2
        ]);
        $head = \App\Models\User::create([
            'email' => 'head@head.ru',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
            'role_id' => 4,
            'commission' => 2
        ]);
    }
}
