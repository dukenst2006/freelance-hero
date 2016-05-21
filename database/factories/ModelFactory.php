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
        'first_name' => $faker->firstName,
        'last_name'	=> $faker->lastName,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10)
    ];
});

$factory->define(App\Project::class, function(Faker\Generator $faker) {
	return [
		'name' => $faker->name,
		'start_date' => $faker->date,
		'target_end_date' => $faker->date,
		'end_date' => $faker->date,
		'user_id' => factory(App\User::class)->create()->id
	];
});

$factory->define(App\Organization::class, function(Faker\Generator $faker) {
	return [
		'name' => $faker->name,
		'user_id' => factory(App\User::class)->create()->id
	];
});