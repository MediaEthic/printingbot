<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Address;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Address::class, function (Faker $faker) {
    $faker->locale = 'fr_FR';
    return [
        'third_id' => App\Models\Third::all()->random()->id,
        'address_line1' => $faker->streetAddress,
        'address_line2' => $faker->secondaryAddress,
        'postcode' => $faker->postcode,
        'city' => $faker->city,
        'order' => $faker->randomElement([true, false]),
        'delivery' => $faker->randomElement([true, false]),
        'invoicing' => $faker->randomElement([true, false]),
        'default' => $faker->randomElement([true, false]),
    ];
});
