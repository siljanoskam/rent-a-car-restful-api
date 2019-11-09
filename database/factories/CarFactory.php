<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Car;
use App\Location;
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

$factory->define(Car::class, function (Faker $faker) {
    return [
        'brand' => $faker->randomElement(['Jeep', 'Lada', 'Fiat', 'Toyota', 'Peugeot', 'Renault', 'Opel', 'Citroen', 'Volkswagen']),
        'model' => $faker->randomElement(['First example', 'Second example', 'Third example']),
        'year' => $faker->year,
        'fuel_type' => $faker->randomElement(['Gasoline', 'Diesel', 'Natural gas', 'Biodiesel']),
        'price' => $faker->randomFloat(1, 1, 250),
        'available' => $faker->randomElement([true, false]),
        'user_id' => User::all()->random()->id,
        'location_id' => Location::all()->random()->id
    ];
});
