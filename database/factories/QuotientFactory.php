<?php

use Faker\Generator as Faker;

$factory->define(\Quotient::class, function (Faker $faker) {
    return [
        'user_id'   =>  function () {
            if (\User::count()) {
                return \User::inRandomOrder()->first()->id;
            }
            return factory(\User::class)->create()->id;
        },
        'check_id'  => function () {
            if (\Check::count()) {
                return \Check::inRandomOrder()->first()->id;
            }
            return factory(\Check::class)->create()->id;
        },
        'amount'    => $faker->randomFloat(2, 0.01, 1000),
        'status'    => $faker->randomElement([
            \Quotient::NOT_PAID,
            \Quotient::PARTIALLY_PAID,
            \Quotient::PAID,
            \Quotient::APPROVED,
            \Quotient::DISAPPROVED
        ])
    ];
});
