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

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'name' => $faker->numerify('Order ####'),
        'client_id' => function() {
        	return App\Client::inRandomOrder()->first()->id;
        },
        'vehicle_type' => $faker->numberBetween($min = 1, $max = 8),
        'pickup_at' => $faker->dateTimeBetween($startDate = '+10 days', $endDate = '+15 days', $timezone = null),
        'dropoff_at' => $faker->dateTimeBetween($startDate = '+20 days', $endDate = '+40 days', $timezone = null),
        'pickup_location_id' => $faker->numberBetween($min = 1, $max = 1000),
        'dropoff_location_id' => $faker->numberBetween($min = 1, $max = 1000)
    ];
});
