<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\InvoiceProduct;
use Faker\Generator as Faker;

$factory->define(InvoiceProduct::class, function (Faker $faker) {
    $invoiceProduct = App\Models\Invoice::all()->random();
    $qty = $faker->numberBetween(1, 2000);

    return [
        'invoice_id' => $invoiceProduct->id,
        'name' => $faker->sentence,
        'description' => $faker->sentence,
        'qty' => $qty,
        'price' => ($invoiceProduct->total / $qty),
        'total' => $invoiceProduct->total,
    ];
});
