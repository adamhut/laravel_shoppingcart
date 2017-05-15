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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Product::class, function (Faker\Generator $faker) {

    return [
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'image_path' => "http://placehold.it/350x150",
        'price' => $faker->numberBetween(100,2000),

    ];
});


$factory->define(App\Customer::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->phoneNumber,

    ];
});