<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class FrontendAssetsTest extends TestCase
{
    #[DataProvider('publicPages')]
    public function test_public_pages_use_compiled_css_and_one_local_alpine_runtime(string $url): void
    {
        $response = $this->get($url)
            ->assertOk()
            ->assertSee('href="/css/app.css?v=', false)
            ->assertDontSee('cdn.tailwindcss.com', false)
            ->assertDontSee('cdn.jsdelivr.net/npm/alpinejs', false);

        $runtimeCount = preg_match_all(
            '~<script\b[^>]*\bsrc=["\'][^"\']*/livewire(?:\.min)?\.js(?:\?[^"\']*)?["\']~',
            $response->getContent(),
        );

        $this->assertSame(1, $runtimeCount, 'Each page must load Livewire\'s bundled Alpine exactly once.');
    }

    public static function publicPages(): array
    {
        return [
            'home' => ['/'],
            'why' => ['/why'],
            'compiler' => ['/features/compiler'],
            'fragments' => ['/features/fragments'],
        ];
    }
}
