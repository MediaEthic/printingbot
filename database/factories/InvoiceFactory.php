<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Invoice;
use App\Models\InvoiceLine;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Invoice::class, function (Faker $faker) {
    $lines = collect();

    $numberLines = $faker->numberBetween(1, 10);

    for ($i = 1; $i <= $numberLines; $i++) {
        $type = $faker->randomElement(['comment', 'product']);

            if ($type === 'product') {
                $vat = App\Models\Vat::all()->random();
                $vatID = $vat->id;
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
                $discountAmount = -1 * abs($subtotal * ($discountRate / 100));
                $totalPretax = round($subtotal + $discountAmount, 2);
                $vatAmount = round($totalPretax * ($vat->rate / 100), 2);
                $total = round($totalPretax + $vatAmount, 2);
            } else {
                $product = null;
                $vatID = null;
                $quantity = null;
                $unitPrice = null;
                $subtotal = null;
                $discountRate = null;
                $discountAmount = null;
                $totalPretax = null;
                $vatAmount = null;
                $total = null;
            }


        $lines->push(new InvoiceLine([
            'type' => $type,
            'description' => $faker->sentence,
            'product_id' => $product,
            'vat_id' => $vatID,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'subtotal' => $subtotal,
            'discount_rate' => $discountRate,
            'discount_amount' => $discountAmount,
            'total_pretax' => $totalPretax,
            'vat' => $vatAmount,
            'total' => $total,
        ]));

    }

    $invoiceDate = $faker->date();

    $lastInvoice = Invoice::latest()->first();
    if ($lastInvoice) {
        $id = $lastInvoice->id + 1;
    } else {
        $id = 1;
    }
    $invoiceNo = date("ym", strtotime($invoiceDate)) . str_pad($id, 6, 0, STR_PAD_LEFT);

    $third = App\Models\Third::where('type', 'customer')->get()->random();

    $invoiceSubtotal = $lines->sum('subtotal');
    $invoiceDiscountAmount = $lines->sum('discount_amount');
    $invoiceTotalPretax = $lines->sum('total_pretax');
    $invoiceVat = $lines->sum('vat');

    $commission_rate = $third->commission_rate;
    $commission_amount = round($invoiceSubtotal * ($commission_rate / 100),2);
    $invoiceTotal = round($invoiceTotalPretax + $invoiceVat, 2);


    $invoice = Invoice::create([
        'created_at' => $invoiceDate,
        'updated_at' => $invoiceDate,
        'establishment_id' => App\Models\Establishment::all()->random()->id,
        'invoice_no' => $invoiceNo,
        'updated_by' => App\Models\User::all()->random()->id,
        'name' => $faker->sentence,
        'invoice_date' => $invoiceDate,
        'due_date' => $faker->date(),
        'invoice_status' => $faker->randomElement(['draft', 'edited', 'payed']),
        'third_id' => $third->id,
        'third_alias' => $third->alias,
        'third_name' => $third->name,
        'third_address_line1' => $third->address_line1,
        'third_address_line2' => $third->address_line2,
        'third_address_line3' => $third->address_line3,
        'third_postcode' => $third->postcode,
        'third_city' => $third->city,
        'country_id' => $third->country_id,
        'third_intracommunity_no' => $third->intracommunity_no,
        'third_reference' => $faker->sentence,
        'user_id' => $third->user_id,
        'user_commission_base' => $invoiceSubtotal,
        'user_commission_rate' => $commission_rate,
        'user_commission_amount' => $commission_amount,
        'discount_rate' => $third->discount_rate,
        'bank_rate' => $third->bank_rate,
        'discount_duration' => $third->discount_duration,
        'payment_id' => App\Models\Payment::all()->random()->id,
        'settlement_id' => App\Models\Settlement::all()->random()->id,
        'subtotal' => $invoiceSubtotal,
        'discount_amount' => $invoiceDiscountAmount,
        'total_pretax' => $invoiceTotalPretax,
        'vat' => $invoiceVat,
        'total' => $invoiceTotal,
    ]);

    $invoice->lines()->saveMany($lines);

    return $invoice->toArray();
});
