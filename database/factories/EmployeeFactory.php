<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'id_branch'         => $faker->numberBetween($min = 1, $max = 3),
        'id_title'          => $faker->numberBetween($min = 1, $max = 3),
        'firstname'         => $faker->firstName,
        'lastname'          => $faker->lastName,
        'gender'            => $faker->randomElement(['L', 'P']),
        'nik'               => $faker->randomNumber(7),
        'address'           => $faker->address,
        'address_two'       => $faker->address,
        'email'             => $faker->unique()->safeEmail,
        'mobile'            => $faker->phoneNumber,
        'phone'             => $faker->phoneNumber,
        'phone_two'         => $faker->phoneNumber,
        'hired_at'          => $faker->date('Y-m-d', 'now'),
        'terminated_at'     => null
    ];
});
