<?php

namespace App\Services;

use Illuminate\Support\Str;

class URLShortenerService
{
    // In-memory storage for URL mappings
    private static $urlMap = [];

    /**
     * Encode a URL into a short code.
     *
     * @param string $url
     * @return string
     */
    public static function encode(string $url): string
    {
        // Generate a random 6-character code
        $code = Str::random(6);
        self::$urlMap[$code] = $url;
        return $code;
    }

    /**
     * Decode the short code back into the original URL.
     *
     * @param string $code
     * @return string|null
     */
    public static function decode(string $code): ?string
    {
        return self::$urlMap[$code] ?? null;
    }
}
