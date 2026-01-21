<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

final class AiService
{
    private const BASE_URL = 'https://api.openai.com/v1/responses';
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

        /**
         * ✅ SAFE OUTPUT EXTRACTION (THIS WAS MISSING)
         */
        $html = collect($response->json('output'))
            ->pluck('content')
            ->flatten(1)
            ->pluck('text')
            ->implode("\n");

        if (trim($html) === '') {
            throw new RuntimeException('AI returned empty output.');
        }

        return $this->sanitizeHtml($html);
    }

    private function sanitizeHtml(string $html): string
    {
        $allowed = '<p><br><strong><em><u><a><ul><ol><li><h2><h3><blockquote>';
        $clean = strip_tags($html, $allowed);

        $clean = preg_replace('/\son\w+="[^"]*"/i', '', $clean);
        $clean = preg_replace('/\sstyle="[^"]*"/i', '', $clean);
        $clean = preg_replace('/href="javascript:[^"]*"/i', 'href="#"', $clean);

        return trim($clean);
    }
}
