<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateCheckFeatureTest extends TestCase
{

    use DatabaseTransactions;

    /** @var  \App\Models\User $user */
    protected $user;


    public function setUp()
    {
        parent::setUp();

        $this->actingAs(factory(\User::class)->create());
    }


    /** @test */
    public function create_a_check_with_one_quotient_test()
    {
        /** @var \App\Models\Check $check */
        $check = factory(\Check::class)->make();

        $data = [
            'title' =>  $check->title,
            'description' => $check->description,
            'amount' => $check->amount
        ];

        $data['quotients'][] = [
            'user_id' => factory(\User::class)->create()->id,
            'amount' => $check->amount
        ];

        $response = $this->post(route('api.checks.create'), $data);

        $response->assertStatus(201)
            ->assertJsonStructure(['id']);

        /** @var \App\Models\Check $check */
        $check = \Check::find($response->decodeResponseJson()['id']);

        $this->assertEquals($data['amount'], $check->amount);
        $this->assertEquals($data['title'], $check->title);
        $this->assertEquals($data['description'], $check->description);

        $this->assertCount(1, $check->quotients->toArray());

        $this->assertEquals($data['quotients'][0]['user_id'], $check->quotients->first()->user_id);
        $this->assertEquals($data['quotients'][0]['amount'], $check->quotients->first()->amount);

    }
}
