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

$factory->define(App\Region::class, function (Faker\Generator $faker) {
    $name = $faker->state;
    $slug = str_slug($name, '-');

    return [
        'name' => $name,
        'slug' => $slug,
    ];
});

$factory->define(App\District::class, function (Faker\Generator $faker) {
    $name = $faker->city;
    $slug = str_slug($name, '-');

    return [
        'region_id' => $faker->numberBetween(1, 2),
        'name' => $name,
        'slug' => $slug,
    ];
});

$factory->define(App\Church::class, function (Faker\Generator $faker) {
    $name = $faker->realText(100);
    $slug = str_slug($name, '-');
    return [
        'name' => $name,
        'region_id' => $faker->numberBetween(1, 26),
        'district_id' => $faker->numberBetween(1, 26),
        'description' => $faker->paragraph(4, true),
        'other_name'    => $faker->realText(70),
        'address'   => $faker->address,
        'slug' => $slug,
        'category_id' => $faker->numberBetween(1, 4),
        'user_id' => $faker->numberBetween(1, 10),
        'lat' => $faker->latitude($min = -90, $max = 90),
        'lng' => $faker->longitude($min = -180, $max = 180),
    ];
});

$factory->define(App\Phone::class, function (Faker\Generator $faker) {
    return [
        'church_id' => $faker->numberBetween(1, 2),
        'number' => $faker->e164PhoneNumber,
    ];
});

$factory->define(App\Email::class, function (Faker\Generator $faker) {
    return [
        'church_id' => $faker->numberBetween(1, 2),
        'address' => $faker->companyEmail,
    ];
});

$factory->define(App\Event::class, function (Faker\Generator $faker) {
    $title = $faker->sentences(3, true);
    $slug = str_slug($title, '-');
    return [
        'church_id' => $faker->numberBetween(1, 20),
        'title' => $title,
        'slug' => $slug,
        'description' => $faker->realText(200, 2),
        'time' => $faker->dateTimeThisYear($max='tomorrow'),
    ];
});
