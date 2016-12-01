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

    $faker->addProvider(new Faker\Provider\en_IN\Person($faker));
    $faker->addProvider(new Faker\Provider\en_IN\Address($faker));
    $faker->addProvider(new Faker\Provider\en_IN\PhoneNumber($faker));

    $fakeAddress = [
        'mailing-address' => $faker->address,
        'address_flat_house_floor_building' => $faker->address,
        'address_colony_street_locality' => $faker->streetAddress,
        'address_landmark' => $faker->country,
        'address_town_city' => $faker->city,
        'postcode' => $faker->postcode,
        'state' => $faker->state,
    ];
    $phoneNumber = $faker->randomElement(Inzaana\User::areaCodes()) . '-' . preg_replace('/\+[0-9]{2}/', '', $faker->e164PhoneNumber);
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'password' => bcrypt(str_random(10)),
        'verified' => true,
        'remember_token' => str_random(10),
        'phone_number' => $phoneNumber,
        'address' => Inzaana\User::encodeAddress($fakeAddress),
    ];
});

$factory->define(Inzaana\Store::class, function (Faker\Generator $faker) {

    $faker->addProvider(new Faker\Provider\en_IN\Person($faker));
    $faker->addProvider(new Faker\Provider\en_IN\Address($faker));
    $faker->addProvider(new Faker\Provider\en_US\Company($faker));

	$storeName = $faker->company;
    $fakeAddress = [
        'mailing-address' => $faker->address,
        'address_flat_house_floor_building' => $faker->address,
        'address_colony_street_locality' => $faker->streetAddress,
        'address_landmark' => $faker->country,
        'address_town_city' => $faker->city,
        'postcode' => $faker->postcode,
        'state' => $faker->state,
    ];
    return [
        'name' => $storeName,
        // 'domain' => 'com',//$faker->tld,
        'address' => Inzaana\User::encodeAddress($fakeAddress),
        'name_as_url' => strtolower(preg_replace('/[\s.,\']/', '', $storeName)),
        // 'sub_domain' => 'inzaana',
        'store_type' => 'NOT_SURE',
        'description' => $faker->realText($faker->numberBetween(50,100)),
        'status' => 'ON_APPROVAL',
    ];
});