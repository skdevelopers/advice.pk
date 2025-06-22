<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\AiService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

/**
 * Class ProjectController
 *
 * Manages CRUD operations for projects with gallery uploads and AI SEO.
 */
class ProjectController extends Controller
{
    /**
     * Display a list of projects.
     *
     * @param Request $request
     * @return View|JsonResponse
     */
    public function index(Request $request): View|JsonResponse
    {
        $projects = Project::latest()->with('media')->get();

        if ($request->expectsJson()) {
            return response()->json(['data' => $projects]);
        }

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.projects.create');
    }

    /**
     * Store a new project.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws ConnectionException
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'heading'          => 'nullable|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:projects,slug',
            'meta_keywords'    => 'nullable|string',
            'meta_description' => 'nullable|string',
            'description'      => 'nullable|string',
            'longitude'        => 'nullable|string|max:100',
            'latitude'         => 'nullable|string|max:100',
            'floor_plan'       => 'nullable|file|mimes:pdf,png,jpg,jpeg,svg|max:2048',
            'gallery.*'        => 'nullable|image|max:2048',
        ]);

        $seo = app(AiService::class)->generate($data['title'], optional($request->city)->name);
        $data['meta_description'] ??= $seo['description'] ?? null;
        $data['meta_keywords'] ??= $seo['keywords'] ?? null;

        $project = Project::create([
            ...$data,
            'user_id' => auth()->id() ?? 1,
            'domain'  => $request->get('domain', 'advice.pk'),
            'slug'    => $data['slug'] ?? Str::slug($data['title']),
        ]);

        // Media upload
        if ($request->hasFile('floor_plan')) {
            $project->addMediaFromRequest('floor_plan')
                ->toMediaCollection('floor_plan');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $project->addMedia($image)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Show the form for editing the project.
     *
     * @param Project $project
     * @return View
     */
    public function edit(Project $project): View
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update an existing project.
     *
     * @param Request $request
     * @param Project $project
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $request->validate([
            'title'            => 'required|string|max:255',
            'heading'          => 'nullable|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:projects,slug,' . $project->id,
            'meta_keywords'    => 'nullable|string',
            'meta_description' => 'nullable|string',
            'description'      => 'nullable|string',
            'longitude'        => 'nullable|string|max:100',
            'latitude'         => 'nullable|string|max:100',
            'floor_plan'       => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:2048',
            'gallery.*'        => 'nullable|image|max:2048',
        ]);

        $project->update([
            ...$data,
            'slug' => $data['slug'] ?? Str::slug($data['title']),
        ]);

        if ($request->hasFile('floor_plan')) {
            $project->clearMediaCollection('floor_plan');
            $project->addMediaFromRequest('floor_plan')
                ->toMediaCollection('floor_plan');
        }

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $project->addMedia($image)->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove a project (soft delete).
     *
     * @param Project $project
     * @return RedirectResponse
     */
    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();
        return back()->with('info', 'Project moved to trash.');
    }

    /**
     * Restore a soft-deleted project.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function restore(int $id): RedirectResponse
    {
        $project = Project::onlyTrashed()->findOrFail($id);
        $project->restore();

        return redirect()->route('admin.projects.index')->with('success', 'Project restored successfully.');
    }
}

