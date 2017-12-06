<?php

use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Quotient::all()
            ->each(function (\Quotient $quotient) {
                factory(\Payment::class)
                    ->create([
                        'user_id' => $quotient->user_id,
                        'amount'  => rand(0,5) ? $quotient->amount : (rand(1,ceil($quotient->amount)) * .01)
                    ]);
            });
    }
}
