<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Establishment;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Establishment::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'logo' => $faker->randomElement(['logo-aviron-bayonnais.jpg', 'logo-ethic-software.png', 'logo-igp-bayonne.jpg', 'logo-ville-bayonne.jpg']),
        'address_line1' => $faker->streetAddress,
        'address_line2' => $faker->secondaryAddress,
        'postcode' => $faker->postcode,
        'city' => $faker->city,
        'phone' => $faker->serviceNumber,
        'email' => $faker->email,
        'head_quotation' => $faker->text,
        'foot_quotation' => $faker->sentence,
        'head_delivery' => $faker->text,
        'foot_delivery' => $faker->sentence,
        'head_invoice' => $faker->text,
        'foot_invoice' => "Tout incident de paiement est passible d'intérêt de retard. Le montant des pénalités résulte de l'application aux sommes restants dues d'un taux d'intérêt légal en vigueur au moment de l'incident. Indemnité forfaitaire pour frais de recouvrement due au créancier en cas de retard de paiement : 40€.",
    ];
});
