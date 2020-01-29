<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProductQuantity;
use Faker\Generator as Faker;

$factory->define(ProductQuantity::class, function (Faker $faker) {
    return [
        'product_id' => App\Models\Product::all()->random()->id,
        'quantity_minimum' => $faker->numberBetween($min = 1, $max = 9999),
        'quantity_maximum' => $faker->numberBetween($min = 2, $max = 9999),
        'unit_price' => $faker->randomFloat($nbMaxDecimals = 4, $min = 0, $max = 100),
    ];
});
