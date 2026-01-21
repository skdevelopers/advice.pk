<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Class AiService
 *
 * Central AI service for SEO + editor content transforms.
 * Optimized for Quill editors.
 */
final class AiService
{
    /**
     * Chat Completions endpoint.
     */
    private const BASE_URL = 'https://api.openai.com/v1/chat/completions';

    /**
     * Stable cost-quality model.
     */
    private const MODEL = 'gpt-4o-mini';

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

        $system = <<<SYS
                    You are a professional real estate content writer.

                    Output ONLY clean HTML suitable for a Quill editor.

                    Allowed tags:
                    p, br, strong, em, u, a, ul, ol, li, h2, h3, blockquote

                    Rules:
                    - No scripts
                    - No inline styles
                    - No hallucinations
                    - English only
                    SYS;

                            $user = <<<TXT
                    Entity: {$entity}
                    Type: {$type}

                    Task:
                    {$instruction}

                    Input:
                    {$text}
                    TXT;

        $response = Http::withToken($key)->post(self::BASE_URL, [
            'model' => self::MODEL,
            'temperature' => 0.6,
            'max_tokens' => 900,
            'messages' => [
                ['role' => 'system', 'content' => $system],
                ['role' => 'user', 'content' => $user],
            ],
        ]);

        if ($response->failed()) {
            throw new RuntimeException(
                'OpenAI error: ' . ($response->json('error.message') ?? $response->body())
            );
        }

        $html = trim((string) $response->json('choices.0.message.content'));

        return $this->basicHtmlAllowlist($html);
    }

    /**
     * Minimal HTML allowlist sanitizer (frontend-safe complement).
     */
    private function basicHtmlAllowlist(string $html): string
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
