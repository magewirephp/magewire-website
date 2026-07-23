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

    public function test_theme_compatibility_uses_visual_status_cards(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Platforms')
            ->assertDontSee('Platforms &amp; runtime', false)
            ->assertSee('Mage-OS')
            ->assertSee('Magento Open Source')
            ->assertSee('Adobe Commerce')
            ->assertDontSee('PHP 8.2 - 8.5')
            ->assertDontSee('Magento Commerce')
            ->assertDontSee('1.3.1 to 3.2.0')
            ->assertDontSee('2.4.6-p15 to 2.4.9')
            ->assertDontSee('2.4.6 to 2.4.9')
            ->assertDontSee('8.2 to 8.5')
            ->assertSee('Themes')
            ->assertDontSee('Themes &amp; areas', false)
            ->assertDontSee('Where Magewire runs')
            ->assertDontSee('How Magewire meets the frontend')
            ->assertSee('/images/compatibility/mage-os.webp', false)
            ->assertSee('/images/compatibility/magento-open-source.webp', false)
            ->assertSee('/images/compatibility/adobe-commerce.webp', false)
            ->assertDontSee('/images/compatibility/php.webp', false)
            ->assertDontSee('Compatibility matrix')
            ->assertDontSee('Supported Magewire V3 combinations')
            ->assertDontSee('7 combinations')
            ->assertSee('2.4.6-p15')
            ->assertSee('2.4.7-p10')
            ->assertSee('2.4.8-p5')
            ->assertSee('1.3.1')
            ->assertSee('2.3.0')
            ->assertSee('3.2.0')
            ->assertSee('Magento 2.4.8-p2 base; Magewire PHP floor')
            ->assertSee('Magento 2.4.8-p5 base')
            ->assertSee('Magento 2.4.9 base; latest/latest')
            ->assertSee('/images/compatibility/backend.webp', false)
            ->assertSee('/images/compatibility/hyva.webp', false)
            ->assertSee('href="https://github.com/magewirephp/magewire-hyva-theme"', false)
            ->assertSee('/images/compatibility/breeze.webp', false)
            ->assertSee('/images/compatibility/luma.webp', false)
            ->assertSee('In progress · Community')
            ->assertSee('No active plans');
    }

    public function test_why_page_tells_the_project_story(): void
    {
        $this->get('/why')
            ->assertOk()
            ->assertSee('Reactive Magento.')
            ->assertSee('The wheel was already round.')
            ->assertSee('Livewire had already proven')
            ->assertSee('The goal was never to invent another frontend philosophy.')
            ->assertSee('Familiar does not mean identical.')
            ->assertSee('Yes, an HTTP request has a cost.')
            ->assertSee('Magewire V3 increasingly keeps state and behavior in the browser.')
            ->assertSee('a small, intentional request cost is often a good trade')
            ->assertSee('New ideas belong in Magento too.')
            ->assertSee('https://github.com/sponsors/wpoortman', false)
            ->assertSee('id="site-nav"', false)
            ->assertSee('nav-glass fixed', false)
            ->assertSee('https://discord.gg/magewire', false)
            ->assertSeeInOrder(['>Docs</a>', '>Why</a>', '>Install</a>'], false)
            ->assertDontSee('Dear builders')
            ->assertDontSee('open letter');

        $this->get('/')
            ->assertOk()
            ->assertSee(route('why'), false)
            ->assertSee('Why')
            ->assertSeeInOrder(['>Docs</a>', '>Why</a>', '>Install</a>'], false)
            ->assertSee('https://github.com/sponsors/wpoortman', false)
            ->assertDontSee('https://github.com/sponsors/magewirephp', false);

        $this->get('/why-magewire')
            ->assertRedirect('/why');

        $this->get('/about')
            ->assertRedirect('/why');
    }
}
