<?php

use Faker\Generator as Faker;

$factory->define(\Payment::class, function (Faker $faker) {
    return [
        'user_id'   => function () {
            if (\User::count()) {
                return \User::inRandomOrder()->first()->id;
            }
            return factory(\User::class)->create()->id;
        },
        'amount'    => $faker->randomFloat(2, 0.1, 9999),
        'comment'   => $faker->boolean(70) ? '' : $faker->sentence(rand(2, 10)),
        'status'    => $faker->boolean(60)
            ? \Payment::APPROVED
            : $faker->randomElement([
                \Payment::DEFAULT_STATUS,
                \Payment::APPROVED,
                \Payment::DISAPPROVED
            ])
    ];
});
