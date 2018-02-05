<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCheckFeatureTest extends TestCase
{

    /** @var \App\Models\Check */
    protected $check;

    public function setUp()
    {
        parent::setUp();

        $this->check = factory(\Check::class)
            ->create(['status' => \Check::NOT_PAID]);

        factory(\Quotient::class, 4)
            ->create([
                'check_id' => $this->check->id,
                'amount' => rand(100, 9999) * .01
            ]);
    }

    /** @test */
    public function edit_check_without_payments()
    {
        /** @var \Illuminate\Support\Collection $quotientsData */
        $quotientsData = $this->check
            ->quotients
            ->map(function (\Quotient $quotient) {
                return [
                    'id'     => $quotient->id,
                    'amount' => $quotient->amount,
                    'user_id'=> $quotient->user_id,
                ];
            });

        $postData = [
            'title' => $this->check->title .' (edited)',
            'amount'=> $quotientsData->sum('amount'),
            'quotients' => $quotientsData->toArray()

        ];

        $response = $this
            ->actingAs($this->check->user, 'api')
            ->patch(
            route('api.checks.update', ['check' => $this->check->id]),
            $postData,
            Settings::AJAX_HEADERS
        );

        $response->assertStatus(200)
            ->assertJsonStructure(['title', 'amount', 'quotients']);

        /** @var array $data */
        $data = $response->decodeResponseJson();

        $this->assertEquals($this->check->user_id, $data['user_id'], 'User ID was dropped');
        $this->assertEquals($postData['amount'], $data['amount'], 'Amount is incorrect');
        $this->assertEquals($postData['title'], $data['title'], 'Title is incorrect');
        $this->assertEquals($this->check->status, $data['status'], 'Status was dropped');
        $this->assertCount(count($postData['quotients']), $data['quotients'], 'Quotients are incorrect');
    }

    /** @test */
    public function delete_a_check()
    {
        $this->actingAs($this->check->user, 'api')
            ->delete(
                route('api.checks.delete', ['check' => $this->check->id]),
                Settings::AJAX_HEADERS
            )
            ->assertStatus(204);

        $this->assertEquals(0, \Check::whereId($this->check->id)->count(), 'Check was not deleted');
    }
}
