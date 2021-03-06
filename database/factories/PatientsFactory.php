<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Patient;
use Faker\Generator as Faker;

$factory->define(Patient::class, function (Faker $faker) {
	return [
		'user_id' => 1,
		'name1' => $faker->firstName,
		'name2' => $faker->firstName,
		'surname1' => $faker->lastName,
		'surname2' => $faker->lastName,
		'married_name' => $faker->lastName,
		'gender' => $faker->randomElement(['M', 'F']),
		'civil' => $faker->randomElement(['Single', 'Married']),
		'birth' => $faker->date($format = 'Y-m-d', $max = 'now'),
		'patient_code' => 'CA' . rand(11111, 99999),
		'document_type' => $faker->randomElement(['ID number', 'Passport']),
		'document' => rand(1111, 9999) . '-' . rand(11111, 99999) . '-' . rand(11111, 99999),
		'status' => $faker->randomElement(['Active', 'Disabled']),
		'name_relation' => $faker->name,
		'kinship' => $faker->randomElement(['Spouse', 'Mother','Father', 'Partner','Son or Daughter', 'Aunt or Uncle','Cousin','Other']),
		'phone1' => rand(11111111, 99999999),
		'phone2' => rand(11111111, 99999999),
		'email' => $faker->unique()->safeEmail,
		'address' => $faker->address,
		'city_town' => 'La Ceiba',
	];
});
