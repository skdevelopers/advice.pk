<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Class AiService
 *
 * Central AI service for SEO + editor content transforms.
 * Optimized for Quill editors (HTML output).
 */
final class AiService
{
    /**
     * OpenAI Responses API endpoint.
     */
    private const BASE_URL = 'https://api.openai.com/v1/responses';

    /**
     * Stable, supported model.
     */
    private const MODEL = 'gpt-4.1-mini';

    /**
     * Transform editor text (rewrite / expand / shorten).
     *
     * @throws ConnectionException
     */
    public function transformEditorText(
        string $entity,
        string $type,
        string $action,
        string $text
    ): string {
        $key = trim((string) config('services.openai.key'));

        if ($key === '') {
            throw new RuntimeException('OPENAI_API_KEY is missing.');
        }

        $instruction = match ($action) {
            'rewrite' => 'Rewrite professionally, improve clarity and SEO.',
            'expand'  => 'Expand with more detail, add headings and bullet points.',
            'shorten' => 'Shorten while keeping key points and SEO value.',
            default   => 'Rewrite professionally.',
        };

        $prompt = <<<PROMPT
        You are a professional real estate content writer.

        Task:
        {$instruction}

        Entity: {$entity}
        Type: {$type}

        Rules:
        - Output ONLY clean HTML
        - Allowed tags: p, br, strong, em, u, a, ul, ol, li, h2, h3, blockquote
        - No scripts
        - No inline styles
        - English only

        Input:
        {$text}
        PROMPT;

        $response = Http::withToken($key)
            ->acceptJson()
            ->post(self::BASE_URL, [
                'model' => self::MODEL,
                'input' => $prompt,
                'max_output_tokens' => 900,
            ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'OpenAI error: ' . ($response->json('error.message') ?? $response->body())
            );
        }

        $html = trim((string) data_get($response->json(), 'output_text'));

        return $this->sanitizeHtml($html);
    }

    /**
     * Minimal HTML allowlist sanitizer.
     */
    private function sanitizeHtml(string $html): string
    {
        if ($html === '') {
            return '';
        }

        $allowed = '<p><br><strong><em><u><a><ul><ol><li><h2><h3><blockquote>';
        $clean = strip_tags($html, $allowed);

        $clean = preg_replace('/\son\w+="[^"]*"/i', '', $clean);
        $clean = preg_replace('/\sstyle="[^"]*"/i', '', $clean);
        $clean = preg_replace('/href="javascript:[^"]*"/i', 'href="#"', $clean);

        return trim($clean);
    }
}
