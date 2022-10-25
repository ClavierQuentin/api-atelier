<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_form_with_white_space()
    {
        $response = $this->post('api/message',[
            'prenom'=>'    ',
            'nom' => 'Test',
            'sujet'=> 'test',
            'email' => 'test@url.com',
            'message'=>'test',
        ]);
        $response->assertStatus(404);
    }

    public function test_form_with_sucess()

    {
        $response = $this->post('api/message',[
            'prenom'=>'test',
            'nom' => 'Test',
            'sujet'=> 'test',
            'email' => 'test@url.com',
            'message'=>'test',
        ]);
        $response->assertStatus(200);
    }

    public function test_form_with_honeypot()

    {
        $response = $this->post('api/message',[
            'prenom'=>'test',
            'nom' => 'Test',
            'sujet'=> 'test',
            'email' => 'test@url.com',
            'message'=>'test',
            'pot' => 'test'
        ]);
        $response->assertStatus(404);
    }

}
