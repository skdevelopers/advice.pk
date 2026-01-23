<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * Class AiService
 *
 * Central AI service for editor transformations (Quill-safe).
 * Uses OpenAI Responses API with defensive parsing + debug logging.
 */
final class AiService
{
    /**
     * OpenAI Responses endpoint.
     */
    private const BASE_URL = 'https://api.openai.com/v1/responses';

    /**
     * Lightweight, fast, editor-optimized model.
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

        /**
         * 🚨 Transport / API failure
         */
        if ($response->failed()) {
            Log::error('OpenAI HTTP failure', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            if ($response->status() === 429) {
                Log::warning('OpenAI rate limit hit', [
                    'user_id' => auth()->id(),
                    'headers' => $response->headers(),
                ]);

                throw new RuntimeException(
                    'AI is temporarily busy. Please wait 20–30 seconds and try again.'
                );
            }

            throw new RuntimeException(
                'OpenAI request failed (HTTP ' . $response->status() . ')'
            );
        }

        $data = $response->json();

        /**
         * 🔍 DEBUG LOG (only useful when something breaks)
         * Safe to keep in production (low volume, high value)
         */
        Log::debug('OpenAI raw response', [
            'response' => $data,
        ]);

        /**
         * ✅ UNIVERSAL OUTPUT EXTRACTION
         * Covers all known Responses API variants
         */
        $html = '';

        // 1️⃣ Preferred: output_text shortcut (newer accounts)
        if (!empty($data['output_text'])) {
            $html = (string) $data['output_text'];
        }

        // 2️⃣ Standard Responses API structure
        if ($html === '' && isset($data['output']) && is_array($data['output'])) {
            $html = collect($data['output'])
                ->pluck('content')
                ->flatten(1)
                ->pluck('text')
                ->implode("\n");
        }

        // 3️⃣ Absolute fallback (defensive)
        if ($html === '' && isset($data['output'][0]['content'][0]['text'])) {
            $html = (string) $data['output'][0]['content'][0]['text'];
        }

        if (trim($html) === '') {
            Log::error('OpenAI returned empty output', [
                'parsed_output' => $data,
            ]);

            throw new RuntimeException('AI returned empty output.');
        }

        return $this->sanitizeHtml($html);
    }

    /**
     * Minimal HTML allowlist sanitizer (Quill-safe).
     */
    private function sanitizeHtml(string $html): string
    {
        $allowed = '<p><br><strong><em><u><a><ul><ol><li><h2><h3><blockquote>';

        $clean = strip_tags($html, $allowed);

        // Remove inline JS handlers
        $clean = preg_replace('/\son\w+="[^"]*"/i', '', $clean);

        // Remove inline styles
        $clean = preg_replace('/\sstyle="[^"]*"/i', '', $clean);

        // Neutralize javascript: links
        $clean = preg_replace('/href="javascript:[^"]*"/i', 'href="#"', $clean);

        return trim($clean);
    }
}
