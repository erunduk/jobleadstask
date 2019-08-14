<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\State;
use Faker\Generator as Faker;


/*
|--------------------------------------------------------------------------
| State Model Factory
|--------------------------------------------------------------------------
|
| Here we assemble data for fake state model instance containing a random name.
|
*/

$factory->define(State::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
    ];
});
