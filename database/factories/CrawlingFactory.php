<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\Crawling;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Crawling::class, function (Faker $faker) {
    return [
        'url' => $faker->url,
        'status' => Crawling::BEFORE_CRAWLING,
        'crawled_at' => $faker->date('Y-m-d', 'now'),
    ];
});
