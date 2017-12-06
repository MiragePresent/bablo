<?php

use Faker\Generator as Faker;

$factory->define(\Check::class, function (Faker $faker) {
    return [
        'user_id'       => function () {
            return factory(\User::class)->create()->id;
        },
        'amount'        => $faker->randomFloat(2, 10, 9999),
        'title'         => $faker->sentence(rand(2,6)),
        'description'   => $faker->paragraph(rand(2,4)),
        'status'        => $faker->randomElement([
            \Check::NOT_PAID,
            \Check::PARTIALLY_PAID,
            \Check::PAID
        ])
    ];
});
