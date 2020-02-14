<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contact;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'third_id' => App\Models\Third::all()->random()->id,
        'title' => $faker->randomElement(['Mr.', 'Ms.']),
        'name' => $faker->firstName,
        'lastname' => $faker->lastName,
        'profession' => $faker->jobTitle,
        'service' => $faker->word,
        'email' => $faker->email,
        'mobile' => $faker->mobileNumber ,
        'phone' => $faker->phoneNumber,
        'default' => $faker->randomElement([true, false]),
    ];
});
