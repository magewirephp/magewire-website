<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_hyva_products_are_presented_as_visual_highlights(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('/images/hyva/checkout.webp', false)
            ->assertSee('/images/hyva/cms.webp', false)
            ->assertSee('Powered by Magewire · V1 + V3')
            ->assertSee('Built on a tailored Magewire fork')
            ->assertDontSee('Magewire brings the reactive checkout experience to life.')
            ->assertDontSee('A streamlined, tailored fork shaped around the needs of Hyvä Commerce.');
    }
}
