<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteEmailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_unsubscribe_without_id_key()
    {
        $response = $this->post('delete-email',[
            'email'=>'test@test.fr',
        ]);

        $response->assertStatus(403);
    }

    public function test_unsubscribe_with_empty_id_key()
    {
        $response = $this->post('delete-email',[
            'email'=>'test@test.fr',
            'identifiant'=>''
        ]);

        $response->assertStatus(403);
    }

    public function test_unsubscribe_with_wrong_id_key()
    {
        $response = $this->post('delete-email',[
            'email'=>'test@test.fr',
            'identifiant'=> 'test'
        ]);

        $response->assertStatus(404);
    }
}
