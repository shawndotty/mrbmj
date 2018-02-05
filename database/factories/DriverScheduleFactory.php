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

$factory->define(App\DriverSchedule::class, function (Faker $faker) {
    return [
        'start_at' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+20 days', $timezone = null),
        'end_at' => $faker->dateTimeBetween($startDate = '+30 days', $endDate = '+50 days', $timezone = null),
        'type' => $faker->numberBetween($min = 2, $max = 4),
        'driver_id' => function() {
        	return App\Driver::inRandomOrder()->first()->id;
        },
    ];
});
