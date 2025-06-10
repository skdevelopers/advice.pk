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
     * Generate SEO metadata for a given title.
     *
     * @param string $title
     * @return array
     * @throws ConnectionException
     */
    public function generate(string $title): array
    {
        $prompt = <<<PROMPT
                    You are an SEO expert. Based on the given page title, generate:
                    - A clear and concise SEO Title (max 60 characters)
                    - A compelling SEO Description (max 150 characters)
                    - A set of comma-separated SEO Keywords
                    
                    Title: "{$title}"
                    
                    Respond in the following format:
                    SEO Title: ...
                    SEO Description: ...
                    SEO Keywords: ...
                    PROMPT;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'You are an SEO expert.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'max_tokens' => 300,
        ]);

        $text = $response->json('choices.0.message.content', '');

        // Parse AI response
        preg_match('/SEO Title:\s*(.+)/i', $text, $titleMatch);
        preg_match('/SEO Description:\s*(.+)/i', $text, $descMatch);
        preg_match('/SEO Keywords:\s*(.+)/i', $text, $keywordsMatch);

        return [
            'seo_title' => trim($titleMatch[1] ?? substr($text, 0, 60)),
            'seo_description' => trim($descMatch[1] ?? substr($text, 0, 150)),
            'seo_keywords' => trim($keywordsMatch[1] ?? ''),
        ];
    }
}
