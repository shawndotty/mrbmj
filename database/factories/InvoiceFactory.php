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

$factory->define(App\Invoice::class, function (Faker $faker) {

    return [
        'amount' => $faker->randomNumber(3),
        'order_id' => function() {
        	return App\Order::inRandomOrder()->first()->id;
        },
    ];
});
