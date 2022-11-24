<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Book;
use Faker\Generator as Faker;


$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(6, true),
        'author'=> $faker->name,
        'image'=> $faker->image('public/img', 1000, 1000),
    ];
});
