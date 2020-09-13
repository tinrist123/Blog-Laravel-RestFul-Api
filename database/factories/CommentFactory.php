<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(\App\Comment::class, function (Faker $faker) {
    return [
        //
        'Comment' => $faker->text($maxNbChars = 200),
        'user_id' => rand(1, 20),
        'post_id' => rand(1, 40),
        'reply_id' => 0,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
