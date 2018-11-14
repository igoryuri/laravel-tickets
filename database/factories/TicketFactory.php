<?php

use App\Models\Ticket;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'name' => $faker->text(30),
        'description' => $faker->text,
        'type' => rand(1, 2),
        'urgency' => rand(1, 3),
        'impact' => rand(1, 3),
        'image' => null,
        'change' => rand(0, 1),
        'status' => 1,
        'user_id' => 2,
        'category_id' => rand(1, 4),
    ];
});
