<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class URLShortenerService
{
    /**
     * Encode a URL into a short code and store it to Db Cache forever.
     *
     * @param string $url
     * @return string
     */
    public static function encode(string $url): string
    {
        $code = Str::random(6);
        // Save the URL mapping indefinitely with a unique key.
        Cache::forever("short_url:{$code}", $url);
        return $code;
    }

    /**
     * Decode a short code back to the original URL.
     *
     * @param string $code
     * @return string|null
     */
    public static function decode(string $code): ?string
    {
        return Cache::get("short_url:{$code}");
    }
}
