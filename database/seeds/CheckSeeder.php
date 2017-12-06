<?php

use Illuminate\Database\Seeder;

class CheckSeeder extends Seeder
{

    protected $count = 30;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\Check::class, $this->count)
            ->create()
            ->each(function (\Check $check) {

                $count = rand(1, 7);

                factory(\Quotient::class, $count)
                    ->create([
                        'check_id' => $check->id,
                        'amount'   => $check->amount / $count
                    ]);
            });
    }
}
