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
    	'first_name' => $faker->name,
    	'last_name' => $faker->name,
        'name' => $faker->name,
        'username' => $faker->username,
        'email' => $faker->email,
        'password' => bcrypt('hasani'),
        'remember_token' => str_random(10),
        'role' => rand(0,2),
        'mobile' => rand(10000000000, 99999999999),
        'national_code' => rand(1000000000, 9999999999),
        'credit' => 0,
        'agent_id' => App\User::orderBy('id', 'rand()')->first()->id,
        'price_groups_id' => rand(1,10)
    ];
});
$factory->define(App\Occupation::class, function(Faker\Generator $faker){
	return [
		'title' => $faker->name()
	];
});
$factory->define(App\Brand::class, function(Faker\Generator $faker){
	return [
		'title' => $faker->name()
	];
});
$factory->define(App\NumberBank::class, function(Faker\Generator $faker){
	$address = new Faker\Provider\Address($faker);
	$phone = new Faker\Provider\PhoneNumber($faker);
	return [
		'number' => $phone->phoneNumber(),
		'province_id' => rand(1, 30),
		'city_id' => rand(1, 110),
		'job_id' => App\Occupation::orderByRaw('rand()')->first()->id,
		'postal_code_id' => $address->postcode(),
		'gender' => rand(1,2),
		'brand_id' => App\Brand::orderByRaw('rand()')->first()->id,
	];
});
$factory->define(App\Line::class, function(Faker\Generator $faker){
	$address = new Faker\Provider\Address($faker);
	$phone = new Faker\Provider\PhoneNumber($faker);
	$date = new Faker\Provider\DateTime($faker);
	return [
		'number' => $phone->phoneNumber(),
		'agent_id' => App\User::whereRole('1')->orderByRaw('rand()')->first()->id,
		'user_id' => App\User::whereRole('0')->orderByRaw('rand()')->first()->id,
		'value' => rand(100,900),
		'agent_expires_at' => $date->dateTimeAD(),
		'user_expires_at' => $date->dateTimeAD(),
	];
});
