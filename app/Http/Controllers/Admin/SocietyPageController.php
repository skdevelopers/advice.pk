<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocietyPage;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

/**
 * Class SocietyPageController
 *
 * Handles CRUD and SEO automation for society pages in the admin panel.
 */
class SocietyPageController extends Controller
{
    /**
     * Display a listing of the society pages.
     *
     * @param Request $request
     * @return View|JsonResponse
     */
    public function index(Request $request)
    {
        $societyPages = SocietyPage::with('user')->latest()->get();

        if ($request->expectsJson()) {
            return response()->json(['data' => $societyPages]);
        }

        return view('admin.society-pages.index', compact('societyPages'));
    }

    /**
     * Show the form for creating a new society page.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.society-pages.create');
    }

    /**
     * Store a newly created society page in storage.
     *
     * @param Request $request
     * @param AiService $aiService
     * @return JsonResponse
     */
    public function store(Request $request, AiService $aiService): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:society_pages,slug',
            'heading' => 'required|string|max:255',
            'detail' => 'required|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        $data['user_id'] = auth()->id();
        $data['domain'] = request()->getHost();

        if (empty($data['meta_keywords']) || empty($data['meta_description'])) {
            $seo = $aiService->generate($data['title'], 'Pakistan');
            $data['meta_keywords'] ??= $seo['seo_keywords'];
            $data['meta_description'] ??= $seo['seo_description'];
        }

        $page = SocietyPage::create($data);

        return response()->json(['success' => true, 'data' => $page]);
    }

    /**
     * Show the form for editing the specified society page.
     *
     * @param SocietyPage $societyPage
     * @param Request $request
     * @return View|JsonResponse
     */
    public function edit(SocietyPage $societyPage, Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['data' => $societyPage]);
        }

        return view('admin.society-pages.edit', ['page' => $societyPage]);
    }

    /**
     * Update the specified society page.
     *
     * @param Request $request
     * @param SocietyPage $societyPage
     * @param AiService $aiService
     * @return JsonResponse
     */
    public function update(Request $request, SocietyPage $societyPage, AiService $aiService): JsonResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:society_pages,slug,' . $societyPage->id,
            'heading' => 'required|string|max:255',
            'detail' => 'required|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);

        if (empty($data['meta_keywords']) || empty($data['meta_description'])) {
            $seo = $aiService->generate($data['title'], 'Pakistan');
            $data['meta_keywords'] ??= $seo['seo_keywords'];
            $data['meta_description'] ??= $seo['seo_description'];
        }

        $societyPage->update($data);

        return response()->json(['success' => true, 'data' => $societyPage]);
    }

    /**
     * Remove the specified society page from storage.
     *
     * @param SocietyPage $societyPage
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function destroy(SocietyPage $societyPage, Request $request)
    {
        $societyPage->delete();

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.society-pages.index')->with('message', 'Page deleted.');
    }

    /**
     * Restore a soft-deleted society page.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function restore(int $id): RedirectResponse
    {
        $page = SocietyPage::onlyTrashed()->findOrFail($id);
        $page->restore();

        return redirect()->route('admin.society-pages.index')->with('message', 'Page restored.');
    }
}
