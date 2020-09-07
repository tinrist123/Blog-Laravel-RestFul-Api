<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Category::class, function (Faker $faker) {
    return [
        //
        'CateName' => $faker->domainWord,
        'Alias' => $faker->slug,
        'Picture' =>  $faker->imageUrl($width = 640, $height = 480)
    ];
});
