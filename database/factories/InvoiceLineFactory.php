<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\InvoiceLine;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(InvoiceLine::class, function (Faker $faker) {
    $vat = App\Models\Vat::all()->random();
    $quantity = $faker->numberBetween(1, 5000);
    $unitPrice = $faker->randomFloat($nbMaxDecimals = 4, $min = 0, $max = 100);
    $discountRate = $faker->numberBetween(0, 100);
    $subtotal = $quantity * $unitPrice;
    $subtotalWithDiscount = $subtotal - ($subtotal * ($discountRate / 100));
    $vatAmount = $subtotalWithDiscount * ($vat->rate / 100);
    $total = $subtotalWithDiscount + $vatAmount;
    return [
        'invoice_id' => App\Models\Invoice::all()->random()->id,
        'establishment_id' => App\Models\Establishment::all()->random()->id,
        'description' => $faker->sentence,
        'product_id' => App\Models\Product::all()->random()->id,
        'vat_id' => $vat->id,
        'quantity' => $quantity,
        'unit_price' => $unitPrice,
        'discount_rate' => $discountRate,
        'subtotal' => $subtotalWithDiscount,
        'vat' => $vatAmount,
        'total' => $total,
    ];
});
