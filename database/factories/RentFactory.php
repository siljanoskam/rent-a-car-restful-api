<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Car;
use App\Location;
use App\Rent;
use App\User;
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

$factory->define(Rent::class, function (Faker $faker) {
    return [
        'start_date' => $faker->dateTimeThisMonth,
        'end_date' => $faker->dateTimeThisMonth,
        'starting_location' => Location::all()->random()->id,
        'ending_location' => Location::all()->random()->id,
        'car_id' => Car::all()->random()->id,
        'user_id' => User::all()->random()->id,
    ];
});
