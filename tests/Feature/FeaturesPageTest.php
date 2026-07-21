<?php

namespace Tests\Feature;

use Tests\TestCase;

class FeaturesPageTest extends TestCase
{
    public function test_the_features_index_opens_the_compiler_page(): void
    {
        $this->get('/features')
            ->assertRedirect('/features/compiler');
    }

    public function test_the_compiler_has_its_own_feature_page(): void
    {
        $this->get('/features/compiler')
            ->assertOk()
            ->assertSee('Compiler.')
            ->assertSee('Expressive directives. Still unmistakably Magento.')
            ->assertSee('magewire:compile:clear')
            ->assertSee('Read the compiler docs')
            ->assertSee('href="'.route('features.fragments').'"', false)
            ->assertDontSee('Handpicked features');
    }

    public function test_fragments_has_its_own_feature_page(): void
    {
        $this->get('/features/fragments')
            ->assertOk()
            ->assertSee('Fragments.')
            ->assertSee('Structured output. Still unmistakably PHTML.')
            ->assertSee('Read the Fragments docs')
            ->assertSee('One script fragment. Two correct outcomes.')
            ->assertSee('href="'.route('features.compiler').'"', false)
            ->assertDontSee('Handpicked features');
    }
}
