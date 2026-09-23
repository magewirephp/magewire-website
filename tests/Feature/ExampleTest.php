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

    public function test_homepage_examples_and_setup_point_to_current_magewire(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Reactive Magento')
            ->assertSee('written in PHP')
            ->assertSee('Magewirephp\Magewire\Component')
            ->assertSee('shared</span>', false)
            ->assertSee('cms_index_index.xml')
            ->assertSee('Core installed. Choose your integration next.')
            ->assertSee('pages/theming/breeze.html?ref=main-website')
            ->assertDontSee('>Magewire\Component;</span>', false)
            ->assertDontSee('No JavaScript. No context switching.');
    }

    public function test_hyva_products_are_presented_as_visual_highlights(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('/images/hyva/checkout.webp', false)
            ->assertSee('/images/hyva/cms.webp', false)
            ->assertSee('Built with Magewire')
            ->assertSee('Built on a tailored Magewire fork')
            ->assertDontSee('Magewire brings the reactive checkout experience to life.')
            ->assertDontSee('A streamlined, tailored fork shaped around the needs of Hyvä Commerce.');
    }

    public function test_theme_compatibility_uses_visual_status_cards(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Platforms')
            ->assertSee('Mage-OS')
            ->assertSee('Magento Open Source')
            ->assertSee('Adobe Commerce')
            ->assertSee('PHP 8.2 or newer')
            ->assertSee('Tested in the build matrix')
            ->assertSee('Verify in your project')
            ->assertSee('href="https://github.com/magewirephp/magewire/blob/main/.github/workflows/production-build.yml"', false)
            ->assertDontSee('Current 2.4.7 patch line')
            ->assertDontSee('latest/latest')
            ->assertSee('Themes and areas')
            ->assertSee('/images/compatibility/mage-os.webp', false)
            ->assertSee('/images/compatibility/magento-open-source.webp', false)
            ->assertSee('/images/compatibility/adobe-commerce.webp', false)
            ->assertSee('/images/compatibility/backend.webp', false)
            ->assertSee('/images/compatibility/hyva.webp', false)
            ->assertSee('href="https://github.com/magewirephp/magewire-hyva-theme"', false)
            ->assertSee('/images/compatibility/breeze.webp', false)
            ->assertSee('href="https://docs.magewirephp.nl/pages/theming/breeze.html?ref=main-website"', false)
            ->assertSee('/images/compatibility/luma.webp', false)
            ->assertSee('Community integration')
            ->assertSee('Build a theme integration')
            ->assertDontSee('In progress · Community');
    }

    public function test_tools_section_highlights_external_magento_tools(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('id="tools"', false)
            ->assertSee('href="#tools"', false)
            ->assertSee('Useful with Magewire')
            ->assertSee('Tools')
            ->assertSee('make building with Magewire even more fun')
            ->assertSee('Magento Bricklayer')
            ->assertSee('/images/tools/bricklayer.webp', false)
            ->assertSee('href="https://github.com/Inchoo/magento-bricklayer"', false)
            ->assertSee('href="https://inchoo.net/"', false)
            ->assertSee('Made by')
            ->assertSee('Useful for Magewire development')
            ->assertSee('runtime context that source files cannot show')
            ->assertSee('Compatible with Magewire V1 + V3');
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
            ->assertSee('Make requests intentional')
            ->assertSee('A plain <code>wire:model</code> waits for the next action', false)
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
