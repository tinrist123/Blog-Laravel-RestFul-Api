<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(App\Tag::class, function (Faker $faker) {
    return [
        //
        'TagName' => $faker->domainWord,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
