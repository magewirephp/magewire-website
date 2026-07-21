<?php

namespace Tests\Feature;

use Tests\TestCase;

class FeaturesPageTest extends TestCase
{
    public function test_the_features_page_highlights_the_compiler_and_fragments(): void
    {
        $this->get('/features')
            ->assertOk()
            ->assertSee('Compiler.')
            ->assertSee('Expressive directives. Still unmistakably Magento.')
            ->assertSee('magewire:compile:clear')
            ->assertSee('Read the compiler docs')
            ->assertSee('Markup with')
            ->assertSee('Write normal PHTML. Let Magewire handle the hard parts.')
            ->assertSee('Read the Fragments docs')
            ->assertSee('02 Fragments');
    }
}
