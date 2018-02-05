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

$factory->define(App\VehicleSchedule::class, function (Faker $faker) {
    return [
        'start_at' => $faker->dateTimeBetween($startDate = '-20 days', $endDate = 'now', $timezone = null),
        'end_at' => $faker->dateTimeBetween($startDate = '+1 day', $endDate = '+30 days', $timezone = null),
        'type' => $faker->numberBetween($min = 2, $max = 4),
        'vehicle_id' => function() {
        	return App\Vehicle::inRandomOrder()->first()->id;
        },
    ];
});
