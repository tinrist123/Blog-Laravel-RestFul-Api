<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

$factory->define(\App\Post::class, function (Faker $faker) {
    return [
        //
        'user_id' => factory(App\User::class)->create(),
        'cate_id' => factory(App\Category::class)->create(),
        'tag_id' => factory(App\Tag::class)->create(),
        'Title' => $faker->catchPhrase,
        'Alias' => $faker->domainWord,
        'Shor_Description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'Content' => $faker->text($maxNbChars = 5000),                        // 'Fuga totam reiciendis qui architecto fugiat nemo. Consequatur recusandae qui cupiditate eos quod.'
        'Image' => $faker->imageUrl($width = 1280, $height = 720),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
