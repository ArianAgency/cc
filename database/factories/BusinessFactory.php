<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Business;
use Faker\Generator as Faker;

$factory->define(Business::class, function (Faker $faker) {
    return [
        'brand_name'=>$faker->unique()->company,
        'company_name'=>$faker->unique()->company,
        'company_type'=>'مسئولیت محدود',
        'foundation_date'=>$faker->dateTimeBetween('-30 years','now'),
        'register_code'=>$faker->numberBetween(111111111111, 999999999999)

    ];
});
