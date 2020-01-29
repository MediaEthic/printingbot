<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Invoice;
use App\Models\InvoiceLine;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    $lines = collect();

    $numberLines = $faker->numberBetween(1, 10);

    for ($i = 1; $i <= $numberLines; $i++) {
        $vat = App\Models\Vat::all()->random();
        $quantity = $faker->numberBetween(1, 100);
        $product = App\Models\Product::all()->random()->id;
        $productPrice = App\Models\ProductQuantity::where('id', $product)
            ->where('quantity_minimum','<=', $quantity)
            ->where('quantity_maximum','>=', $quantity)
            ->first();

        if (isset($productPrice)) {
            $unitPrice = $productPrice['unit_price'];
        } else {
            $unitPrice = $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 50);
        }

        $discountRate = $faker->numberBetween(0, 100);
        $subtotal = $quantity * $unitPrice;
        $subtotalWithDiscount = round($subtotal - ($subtotal * ($discountRate / 100)), 2);
        $vatAmount = round($subtotalWithDiscount * ($vat->rate / 100), 2);
        $total = round($subtotalWithDiscount + $vatAmount, 2);

        $lines->push(new InvoiceLine([
            'establishment_id' => App\Models\Establishment::all()->random()->id,
            'description' => $faker->sentence,
            'product_id' => $product,
            'vat_id' => $vat->id,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'discount_rate' => $discountRate,
            'subtotal' => $subtotalWithDiscount,
            'vat' => $vatAmount,
            'total' => $total,
        ]));

    }

    $third = App\Models\Third::all()->random();

    $invoiceSubtotal = $lines->sum('subtotal');
    $invoiceVat = $lines->sum('vat');

    $commission_rate = $third->commission_rate;
    $commission_amount = round($invoiceSubtotal * ($commission_rate / 100),2);
    $invoiceTotal = round($invoiceSubtotal + $invoiceVat, 2);


    $invoice = Invoice::create([
        'created_at' => $faker->date(),
        'updated_at' => $faker->date(),
        'updated_by' => App\Models\User::all()->random()->id,
        'name' => $faker->sentence,
        'invoice_date' => $faker->date(),
        'due_date' => $faker->date(),
        'invoice_status' => $faker->randomElement(['draft', 'edited', 'payed']),
        'third_id' => $third->id,
        'third_name' => $third->name,
        'third_address_line1' => $third->address_line1,
        'third_address_line2' => $third->address_line2,
        'third_address_line3' => $third->address_line3,
        'zipcode' => $third->zipcode,
        'city' => $third->city,
        'country_id' => $third->country_id,
        'third_intracommunity_no' => $third->intracommunity_no,
        'third_reference' => $faker->sentence,
        'user_id' => App\Models\User::all()->random()->id,
        'user_commission_base' => $invoiceSubtotal,
        'user_commission_rate' => $commission_rate,
        'user_commission_amount' => $commission_amount,
        'discount_rate' => $third->discount_rate,
        'bank_rate' => $third->bank_rate,
        'discount_duration' => $third->discount_duration,
        'payment_id' => App\Models\Payment::all()->random()->id,
        'settlement_id' => App\Models\Settlement::all()->random()->id,
        'subtotal' => $invoiceSubtotal,
        'vat' => $invoiceVat,
        'total' => $invoiceTotal,
    ]);

    $invoice->lines()->saveMany($lines);

    return $invoice->toArray();
});
