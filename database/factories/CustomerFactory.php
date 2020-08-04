<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    $created_at = $faker->dateTimeBetween('-1 year', 'now');
    $ngseed = rand(0, 1);

    $name = '';
    $gender = '';
    $birthday = $faker->dateTimeBetween('-60 year','-1 months');
    switch ($ngseed) {
        case 0:
            $name = $faker->firstNameFemale;
            $gender = 'زن';
            break;
        case 1:
            $name = $faker->firstNameMale;
            $gender = 'مرد';
            break;
    }


    $msseed = rand(0, 1);
    $marriage_status = '';
    $wedding_anniversary = null;
    switch ($msseed) {
        case 0:
            $marriage_status = 'مجرد';
            break;
        case 1:
            $marriage_status = 'متاهل';
            $wedding_anniversary = $faker->dateTimeBetween('-42 year', 'now');
            break;

    }
    $edseed = rand(0, 5);
    $education = '';
    switch ($edseed) {
        case 0:
            $education = 'زیر دیپلم';
            break;
        case 1:
            $education = 'دیپلم';
            break;
        case 2:
            $education = 'فوق دیپلم';
            break;
        case 3:
            $education = 'لیسانس';
            break;
        case 4:
            $education = 'فوق لیسانس';
            break;
        case 5:
            $education = 'دکترا';
            break;
    }

    $updated_at_seed = rand(0, 5);
    $updated_at = null;
    if ($updated_at_seed == 0) {
        $updated_at = $faker->dateTimeBetween($created_at, 'now');
    }
    $is_active_seed = rand(0, 5);
    $is_active = 1;
    if ($is_active_seed > 0) {
        $is_active = 0;
    }
    $is_deleted_seed = rand(0, 5);
    $is_deleted = 0;
    if ($is_deleted_seed > 0) {
        $is_deleted = 0;
    }

    return [
        'name' => $name,
        'family' => $faker->lastName,
        'father_name' => $faker->firstNameMale,
        'gender' => $gender,
        'mobile' => '09' . $faker->unique()->numberBetween(111111111, 999999999),
        'mobile_verified_at' => $faker->dateTimeBetween($created_at, 'now'),
        'phone' => '021' . $faker->numberBetween(11111111, 99999999),
        'email' => $faker->unique()-> email,
        'email_verified_at' => $faker->dateTimeBetween($created_at, 'now'),
        'have_social' => $faker->numberBetween(0, 1),
        'birthday' => $birthday,
        'marriage_status' => $marriage_status,
        'wedding_anniversary' => $wedding_anniversary,
        'education' => $education,
        'field' => $faker->jobTitle,
        'address' => $faker->unique()->address,
        'registration_origin' => 1,
        'finding_way' => 'website',
        'job' => $faker->jobTitle,
        'card_number' => $faker->numberBetween(0001, 9999) . $faker->unique()->numberBetween(111111111111, 999999999999),
        'customer_ip' => $faker->ipv4,
        'password' => md5('secret'),
        'updated_at' => $updated_at,
        'is_active' => $is_active,
        'is_deleted' => $is_deleted,
    ];
});
