<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\County;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| County Model Factory
|--------------------------------------------------------------------------
|
| Here we assemble data for fake county model instance containing a random name
| and a random tax rate between 5% and 25%.
|
*/

$factory->define(County::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
    ];
});
