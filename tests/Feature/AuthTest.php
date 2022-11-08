<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function test_user_not_admin_get_texte_accueil()
     {
        $user = User::find(2);
        $response = $this->actingAs($user)->get('texte-accueil');

        $response->assertStatus(403);
     }

     public function test_post_not_admin()
     {
        $user = User::find(2);
        $response = $this->actingAs($user)->post('texte-accueil',[
            'titre_accueil'=>'Accueil',
            'texte_accueil'=>'texte',
            'titre_categories'=>'categories'
        ]);

        $response->assertStatus(403);
     }

     public function test_post_is_admin()
     {
        $user = User::find(1);
        $response = $this->actingAs($user)->post('texte-accueil',[
            'titre_accueil'=>'Accueil',
            'texte_accueil'=>'texte',
            'titre_categories'=>'categories'
        ]);

        $response->assertRedirect('texte-accueil');
     }
}
