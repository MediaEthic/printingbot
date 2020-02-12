<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Third;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Third::class, function (Faker $faker) {
    $siren = $faker->randomNumber($nbDigits = 9);
    $siret = $siren . $faker->randomNumber($nbDigits = 5);
    $key = 12 + 3 * ($siren % 97) % 97;
    $intercommunity = "FR " . $key . " " . $siren;
    return [
        'updated_by' => App\Models\User::all()->random()->id,
        'type' => $faker->randomElement(['supplier', 'prospect', 'customer']),
        'name' => $faker->name,
        'alias' => Str::random(5),
        'logo' => $faker->randomElement(['logo-aviron-bayonnais.jpg', 'logo-ethic-software.png', 'logo-igp-bayonne.jpg', 'logo-ville-bayonne.jpg']),
        'address_line1' => $faker->address,
        'address_line2' => $faker->address,
        'address_line3' => $faker->address,
        'zipcode' => $faker->randomNumber($nbDigits = 5),
        'city' => Str::random(10),
        'phone' => $faker->numberBetween($min = 0000000000, $max = 9999999999),
        'email' => $faker->email,
        'ape' => Str::random(5),
        'siret' => $siret,
        'intracommunity_no' => $intercommunity,
        'user_id' => App\Models\User::whereTrade(true)->get()->random()->id,
        'commission_rate' => $faker->numberBetween($min = 0, $max = 100),
        'discount_rate' => $faker->numberBetween($min = 0, $max = 100),
        'bank_rate' => $faker->numberBetween($min = 0, $max = 100),
        'discount_duration' => $faker->numberBetween($min = 0, $max = 30),
        'payment_id' => App\Models\Payment::all()->random()->id,
        'settlement_id' => App\Models\Settlement::all()->random()->id,
        'vat_id' => App\Models\Vat::all()->random()->id,
        'invoice_number' => $faker->numberBetween($min = 1, $max = 3),
        'invoice_copy' => $faker->numberBetween($min = 0, $max = 2),
        'monthend_invoices' => $faker->randomElement([true, false]),
        'grouping_invoices' => $faker->randomElement([true, false]),
        'statement' => $faker->randomElement([true, false]),
    ];
});
