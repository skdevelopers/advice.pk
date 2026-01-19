<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AiEditorTransformRequest;
use App\Services\AiService;
use Illuminate\Http\JsonResponse;

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
}
