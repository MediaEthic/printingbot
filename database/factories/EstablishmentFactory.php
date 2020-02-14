<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Establishment;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Establishment::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'logo' => $faker->randomElement(['logo-aviron-bayonnais.jpg', 'logo-ethic-software.png', 'logo-igp-bayonne.jpg', 'logo-ville-bayonne.jpg']),
        'address_line1' => $faker->address,
        'address_line2' => $faker->address,
        'address_line3' => $faker->address,
        'postcode' => $faker->randomNumber($nbDigits = 5),
        'city' => Str::random(10),
        'phone' => $faker->numberBetween($min = 0000000000, $max = 9999999999),
        'email' => $faker->email,
        'head_quotation' => $faker->text,
        'foot_quotation' => $faker->sentence,
        'head_delivery' => $faker->text,
        'foot_delivery' => $faker->sentence,
        'head_invoice' => $faker->text,
        'foot_invoice' => $faker->paragraph,
    ];
});
