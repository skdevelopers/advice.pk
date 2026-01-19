<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AiEditorTransformRequest;
use App\Services\AiService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class AiEditorController
 *
 * Handles AI actions for Quill editor content (rewrite/expand/shorten).
 */
final class AiEditorController extends Controller
{
    /**
     * @param AiEditorTransformRequest $request
     * @param AiService $aiService
     * @return JsonResponse
     * @throws ConnectionException
     */
    public function transform(AiEditorTransformRequest $request, AiService $aiService): JsonResponse
    {
        $data = $request->validated();

        $html = $aiService->transformEditorText(
            entity: $data['entity'],
            type: $data['type'],
            action: $data['action'],
            text: $data['text']
        );

        if ($html === '') {
            return response()->json([
                'status'  => 'error',
                'message' => 'AI returned empty content.',
            ], 422);
        }

        return response()->json([
            'status' => 'ok',
            'html'   => $html,
        ]);
    }

    /**
     * @param Request $request
     * @param AiService $ai
     * @return JsonResponse
     * @throws ConnectionException
     */
    public function quill(Request $request, AiService $ai): JsonResponse
    {
        $data = $request->validate([
            'entity' => 'required|string|max:50',
            'type'   => 'required|string|max:50',
            'mode'   => 'required|in:generate,rewrite,expand,shorten',
            'html'   => 'nullable|string',
            'title'  => 'nullable|string|max:255',
        ]);

        $source = $data['html'] ?: $data['title'];

        if (!$source) {
            return response()->json(['html' => '']);
        }

        $html = $ai->transformEditorText(
            $data['entity'],
            $data['type'],
            $data['mode'],
            strip_tags($source)
        );

        return response()->json(['html' => $html]);
    }

}
