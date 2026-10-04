<?php

namespace App\Support;

class FrontendAssets
{
    private static ?array $manifest = null;

    public static function url(string $path): string
    {
        self::$manifest ??= json_decode(file_get_contents(public_path('asset-manifest.json')), true, flags: JSON_THROW_ON_ERROR);

        return self::$manifest[$path];
    }
}
