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
        'client_id' => function() {
        	return App\Client::inRandomOrder()->first()->id;
        },
        'type' => $faker->numberBetween($min = 1, $max = 2),
        'pax' => $faker->numberBetween($min = 1, $max = 100),
        'group_type' => $faker->randomElement($array = array (
            'Military/Government', 
            'Club', 
            'Corporate',
            'Education/Academic',
            'Family',
            'Religious',
            'Sports',
            'Youth',
            'Other' )),
        'pickup_at' => $faker->dateTimeBetween($startDate = '+10 days', $endDate = '+15 days', $timezone = null),
        'dropoff_at' => $faker->dateTimeBetween($startDate = '+20 days', $endDate = '+40 days', $timezone = null),
        'pickup_location' => $faker->city(),
        'dropoff_location' => $faker->city(),
    ];
});
