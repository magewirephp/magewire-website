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
            ->assertSee('src="/js/app.js?v=', false)
            ->assertDontSee('cdn.tailwindcss.com', false)
            ->assertDontSee('cdn.jsdelivr.net/npm/alpinejs', false)
            ->assertDontSee('fonts.bunny.net', false)
            ->assertDontSee('livewire.min.js', false)
            ->assertDontSee('livewire.js', false)
            ->assertDontSee('/flux/flux', false);

        $runtimeCount = preg_match_all(
            '~<script\b[^>]*\bsrc=["\'][^"\']*/js/app\.js\?v=[a-f0-9]+["\']~',
            $response->getContent(),
        );

        $this->assertSame(1, $runtimeCount, 'Each page must load the local Alpine bundle exactly once.');
    }

    #[DataProvider('publicPages')]
    public function test_public_pages_are_cacheable_without_session_cookies(string $url): void
    {
        $response = $this->get($url)->assertOk();

        $this->assertTrue($response->headers->hasCacheControlDirective('public'));
        $this->assertSame('300', $response->headers->getCacheControlDirective('max-age'));
        $this->assertEmpty($response->headers->getCookies());
        $this->assertNotEmpty($response->headers->get('ETag'));

        $this->withHeader('If-None-Match', $response->headers->get('ETag'))
            ->get($url)->assertStatus(304)->assertContent('');
    }

    public function test_versioned_frontend_assets_exist_and_bundles_are_compressed(): void
    {
        $manifest = json_decode(file_get_contents(public_path('asset-manifest.json')), true, flags: JSON_THROW_ON_ERROR);

        foreach ($manifest as $path => $url) {
            $contents = file_get_contents(public_path(parse_url($url, PHP_URL_PATH)));
            $hash = substr(hash('sha256', $contents), 0, 12);
            $this->assertTrue(str_contains($url, '?v='.$hash) || str_contains($url, '-'.$hash.'.'), 'Asset URLs must contain their content hash: '.$path);
        }

        foreach (['css/app.css', 'js/app.js'] as $path) {
            $contents = file_get_contents(public_path($path));
            $this->assertSame($contents, gzdecode(file_get_contents(public_path($path.'.gz'))));
            $this->assertLessThan(strlen($contents), filesize(public_path($path.'.br')));
        }

        $this->assertLessThan(100000, filesize(public_path('js/app.js')), 'Static pages should keep their JavaScript bundle below 100 KB.');
    }

    public function test_responsive_images_keep_original_resolution_and_valid_fallbacks(): void
    {
        $manifest = json_decode(file_get_contents(public_path('images/responsive/manifest.json')), true, flags: JSON_THROW_ON_ERROR);

        foreach ($manifest as $source => $image) {
            $original = file_get_contents(public_path($source));
            $this->assertSame($source.'?v='.substr(hash('sha256', $original), 0, 12), $image['fallback']);
            $this->assertStringContainsString($image['fallback'].' '.$image['width'].'w', $image['webp']);

            foreach (['webp', 'avif'] as $format) {
                if (! $image[$format]) {
                    continue;
                }

                $widths = [];
                foreach (explode(', ', $image[$format]) as $candidate) {
                    [$url, $width] = explode(' ', $candidate);
                    $this->assertFileExists(public_path(parse_url($url, PHP_URL_PATH)));
                    $widths[] = (int) $width;
                }
                $this->assertSame($image['width'], max($widths), 'Every format must retain the full source resolution.');
            }
        }
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
