<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(\App\Blogger::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $faker->password,
        'remember_token' => $faker->postcode,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
