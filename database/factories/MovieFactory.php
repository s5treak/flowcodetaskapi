<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Movie;
use Faker\Generator as Faker;

$factory->define(Movie::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'genre' => [$faker->word, $faker->word, $faker->word],
        'description' => $faker->sentence,
        'cover' => asset('img/dev.png'),
        'country_of_production' => $faker->country
    ];
});
