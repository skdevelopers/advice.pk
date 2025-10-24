<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EventbriteClient
{
    public function __construct(
        private ?string $token = null,
        private string $base = '',
    ) {
        $this->token = $this->token ?: (string) config('eventbrite.server_token');
        $this->base  = $this->base  ?: (string) config('eventbrite.base', 'https://www.eventbriteapi.com');
    }

    /**
     * GET an Eventbrite API URL (absolute api_url from webhook, or relative path).
     * Uses the organizer SERVER token (not the attendee OAuth token).
     *
     * @throws \RuntimeException on non-2xx
     */
    public function get(string $apiUrl): array
    {
        $url = str_starts_with($apiUrl, 'http')
            ? $apiUrl
            : rtrim($this->base, '/') . '/' . ltrim($apiUrl, '/');

        $resp = Http::withToken($this->token)->acceptJson()->timeout(12)->get($url);

        if (! $resp->successful()) {
            throw new \RuntimeException("Eventbrite GET {$url} failed ({$resp->status()}): " . $resp->body());
        }

        return $resp->json() ?? [];
    }
}
