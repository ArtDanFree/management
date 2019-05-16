<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Role::create([
            'name' => 'Администратор',
            'slug' => 'admin',
            'permissions' => [
                'show-all-leads' => true,
                'admin' => true,
                'invite-user' => true,
                'update-status' => true,
                'change-role' => true,
                'show-all-statistic' => true,
                'reports' =>true,
                'notification' => true,
                'telegram' => true,
            ]
        ]);
        Role::create([
            'name' => 'Частный инвестор',
            'slug' => 'underwriter',
            'permissions' => [
                'show-all-leads' => true,
                'underwriter' => true,
                'update-status' => true,
                'update-lead-phone' => true,
                'take-on-check' => true,
                'notification' => true,
                'telegram' => true,
                'email' => true,
                'feedback' => true,
            ]
        ]);
        Role::create([
            'name' => 'Лидогенератор',
            'slug' => 'lead',
            'permissions' => [
                'show-own-leads' => true,
                'add-lead' => true,
                'lead' => true,
                'feedback' => true,
                'reports' =>true,
                'api' =>true,
            ]
        ]);
        Role::create([
            'name' => 'Руководитель',
            'slug' => 'head',
            'permissions' => [
                'show-all-leads' => true,
                'invite-user' => true,
                'update-status' => true,
                'show-all-statistic' => true,
                'admin' => true,
            ]
        ]);
        Role::create([
            'name' => 'Заблокирован',
            'slug' => 'banned',
            'permissions' => [
                'banned' => true
            ]
        ]);
    }
}
