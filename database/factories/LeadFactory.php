<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Lead::class, function (Faker $faker) {
    return [
        'user_id' => 3,
        'first_name' => $faker->name,
        'last_name' => $faker->lastName,
        'surname' => $faker->lastName,
        'city_id' => random_int(2,5),
        'money' => random_int(10000, 50000),
        'phone' => $faker->phoneNumber,
        'lead_status' => random_int(1, 4),
        'transaction_status' => random_int(1, 4),
        'created_at' => date('Y-m-d'),
        'type' => random_int(1, 2),
    ];
});
