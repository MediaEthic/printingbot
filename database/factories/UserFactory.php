<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'title' => $faker->randomElement(['Mr.', 'Ms.']),
        'alias' => Str::random(5),
        'name' => $faker->firstName,
        'lastname' => $faker->lastName,
        'establishment_id' => App\Models\Establishment::all()->random()->id,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'api_token' => Str::random(80),
        'mobile' => $faker->e164PhoneNumber ,
        'phone' => $faker->e164PhoneNumber ,
        'accounting' => $faker->randomElement([true, false]),
        'trade' => $faker->randomElement([true, false]),
        'quotation' => $faker->randomElement([true, false]),
        'operator' => $faker->randomElement([true, false]),
        'supervisor' => $faker->randomElement([true, false]),
        'manager' => $faker->randomElement([true, false]),
    ];
});
