<?php

namespace Tests\Feature;

use Tests\TestCase;

class URLShortenerTest extends TestCase
{
    /**
     * Test that encoding returns a valid short URL.
     *
     * @return void
     */
    public function testEncodeEndpoint()
    {
        $response = $this->json('POST', '/api/encode', [
            'url' => 'https://google.com/a-long-url-here-wow-so-long'
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'short_url'
            ]);
    }

    /**
     * Test that a short URL can be decoded back to the original URL.
     *
     * @return void
     */
    public function testDecodeEndpoint()
    {
        // First encode a URL
        $encodeResponse = $this->json('POST', '/api/encode', [
            'url' => 'https://www.example.com'
        ]);

        $encodeResponse->assertStatus(200)
            ->assertJsonStructure(['short_url']);

        $shortUrl = $encodeResponse->json('short_url');

        // Now decode the short URL
        $decodeResponse = $this->json('POST', '/api/decode', [
            'short_url' => $shortUrl
        ]);

        $decodeResponse->assertStatus(200)
            ->assertJson([
                'original_url' => 'https://www.example.com'
            ]);
    }

    /**
     * Test decoding with an invalid short URL.
     *
     * @return void
     */
    public function testDecodeInvalidShortUrl()
    {
        $response = $this->json('POST', '/api/decode', [
            'short_url' => 'http://short.est/invalid'
        ]);

        $response->assertStatus(404)
            ->assertJsonStructure([
                'error'
            ]);
    }
}
