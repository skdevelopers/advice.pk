<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

/**
 * AiService
 *
 * Handles AI-based SEO generation using OpenAI.
 */
class AiService
{
    /**
     * Generate SEO meta data for a given title and city.
     *
     * @param string $title
     * @param string $city
     * @return array
     * @throws ConnectionException
     */
    public function generate(string $title, string $city): array
    {
        $prompt = "Generate SEO meta title, description, and keywords for a real estate society named '{$title}' in '{$city}'.";

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an SEO expert.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 200,
        ]);

        $result = $response->json();

        $text = $result['choices'][0]['message']['content'] ?? '';

        // Optional: Parse response cleanly (you may structure your prompt better for exact formatting)
        return [
            'seo_title' => substr($text, 0, 60), // crude cut, ideally use regex or format request
            'seo_description' => substr($text, 0, 150),
            'seo_keywords' => strtolower(str_replace(' ', ', ', $title . ' ' . $city)),
        ];
    }
}
