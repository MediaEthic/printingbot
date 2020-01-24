<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'invoice_no' => $faker->numberBetween(1000, 4000),
        'invoice_date' => $faker->date(),
        'due_date' => $faker->date(),
        'title' => $faker->sentence,
        'client' => $faker->name,
        'client_address' => $faker->address,
        'sub_total' => $faker->randomFloat($nbMaxDecimals = 4, $min = 100, $max = 10000),
        'discount' => $faker->randomFloat($nbMaxDecimals = 4, $min = 0, $max = 60),
        'total' => $faker->randomFloat($nbMaxDecimals = 4, $min = 100, $max = 10000),
        'status' => $faker->randomElement(['draft', 'edited', 'payed']),
    ];
});
