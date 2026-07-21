<?php

namespace Tests\Feature;

use Tests\TestCase;

class FeaturesPageTest extends TestCase
{
    public function test_the_features_page_highlights_the_compiler(): void
    {
        $this->get('/features')
            ->assertOk()
            ->assertSee('The Compiler')
            ->assertSee('Magewire V3')
            ->assertSee('magewire:compile:clear')
            ->assertSee('Read the compiler docs');
    }
}
