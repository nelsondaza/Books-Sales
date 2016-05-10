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

$factory->define(App\User::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->name,
		'email' => $faker->safeEmail,
		'password' => bcrypt(str_random(10)),
		'remember_token' => str_random(10),
	];
});

$factory->define( \App\Models\Books::class, function (Faker\Generator $faker) {
	return [
		'author' => $faker->name,
		'title' => $faker->sentence( 6 ),
		'reference' => $faker->isbn13, 
		'units_available' => $faker->numberBetween(0,1000),
		'price' => $faker->numberBetween(50000, 200000),
		'published_at' => $faker->dateTime,
	];
});

$factory->define( \App\Models\Sales::class, function (Faker\Generator $faker) {

	$book = \App\Models\Books::orderByRaw("RAND()")->first();

	return [
		'book_id' => $book->id,
		'price' => $book->price,
	];

});
