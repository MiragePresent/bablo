<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentsTest extends TestCase
{

    use RefreshDatabase;

    /** @var \App\Models\Quotient $quotient */
    private $quotient;

    public function setUp()
    {
        parent::setUp();


        $this->quotient = factory(\Quotient::class)
            ->create([
                'status'   => \Quotient::NOT_PAID,
                'check_id' => factory(\Check::class)->create()->id
            ]);
    }

    /** @test */
    public function create_a_payment()
    {
        $this->post(
                route('api.payments.store', [ 'quotient' => $this->quotient->id ]),
                [
                    'amount' => $this->quotient->amount,
                    'comment'=> 'Full payment'
                ],
                Settings::AJAX_HEADERS
            )
            ->assertStatus(201)
            ->assertHeader('location')
            ->assertJsonStructure(['id']);

        $this->assertEquals(\Quotient::PAID, $this->quotient->fresh()->status, 'Quotient status has not been updated');
    }
}
