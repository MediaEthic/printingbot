<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'image' => $faker->randomElement(['undraw_images_aef7.svg', 'undraw_photo_4yb9.svg', 'undraw_tabs_jf82.svg']),
        'name' => $faker->word,
        'alias' => Str::random(5),
        'description' => $faker->sentence,
    ];
});
