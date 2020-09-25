<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;


$factory->define(App\PostAndTag::class, function (Faker $faker) {
    return [
        //
        'post_id' => rand(1, 40),
        'tag_id' => rand(1, 20),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
