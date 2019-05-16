<?php

use Illuminate\Database\Seeder;

class UserCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\UserCity::create([
            'user_id' => 2,
            'city_id' =>1
        ]);
        \App\Models\UserCity::create([
            'user_id' => 2,
            'city_id' =>3
        ]);
        \App\Models\UserCity::create([
            'user_id' => 2,
            'city_id' =>5
        ]);
    }
}
