<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\URLShortenerService;
use Illuminate\Http\JsonResponse;

class URLShortenerController extends Controller
{
    // Base domain for shortened URLs
    protected $baseUrl = 'https://url-shortener.netlify.app/';

    /**
     * Encode the given URL and return a shortened URL.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function encode(Request $request): JsonResponse
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $url = $request->input('url');
        $code = URLShortenerService::encode($url);

        return response()->json([
            'short_url' => $this->baseUrl . $code
        ]);
    }

    /**
     * Decode the given shortened URL back to the original URL.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function decode(Request $request): JsonResponse
    {
        $request->validate([
            'short_url' => 'required|url'
        ]);

        $shortUrl = $request->input('short_url');
        // Extract the code from the short URL by removing the base domain
        $code = str_replace($this->baseUrl, '', $shortUrl);

        $originalUrl = URLShortenerService::decode($code);

        if ($originalUrl) {
            return response()->json([
                'original_url' => $originalUrl
            ]);
        }

        return response()->json([
            'error' => 'Short URL not found.'
        ], 404);
    }
}
