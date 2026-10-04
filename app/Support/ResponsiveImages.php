<?php

namespace App\Support;

class ResponsiveImages
{
    private static ?array $manifest = null;

    public static function get(string $source): array
    {
        self::$manifest ??= json_decode(file_get_contents(public_path('images/responsive/manifest.json')), true, flags: JSON_THROW_ON_ERROR);

        return self::$manifest[$source];
    }
}
