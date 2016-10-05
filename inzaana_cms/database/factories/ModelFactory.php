<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Inzaana\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'password' => bcrypt(str_random(10)),
        'verified' => true,
        'remember_token' => str_random(10),
        'phone_number' => $faker->phoneNumber,
        'address' => $faker->address,
    ];
});

$factory->define(Inzaana\Store::class, function (Faker\Generator $faker) {
	$storeName = $faker->name;
    return [
        'name' => $storeName,
        'domain' => $faker->tld,
        'address' => $faker->address,
        'name_as_url' => strtolower(str_replace(' ', '', $storeName)),
        'sub_domain' => 'inzaana',
        'store_type' => $faker->word,
        'description' => $faker->realText($faker->numberBetween(50,100)),
        'status' => 'ON_APPROVAL',
    ];
});