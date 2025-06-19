<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Services\AiService;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class BlogController extends Controller
{
    protected AiService $aiService;

    public function __construct(AiService $aiService)
    {
        $this->aiService = $aiService;

    }

    /**
     * Display a paginated list.
     */
    public function index(Request $request)
    {
        $blogs = Blog::with('user')->latest()->paginate(10);

        if ($request->expectsJson()) {
            return response()->json($blogs);
        }

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a new blog.
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $blog = Blog::create($data);

        if ($request->hasFile('image')) {
            $blog->addMediaFromRequest('image')
                ->toMediaCollection('blogs');
        }

        // AI SEO if needed
        if (empty($data['meta_keywords']) || empty($data['meta_description'])) {
            $seo = $this->aiService->generate($blog->title, $blog->detail);
            $blog->update([
                'meta_keywords'    => $seo['keywords'],
                'meta_description' => $seo['description'],
            ]);
        }

        return response()->json(['message' => 'Blog created'], 201);
    }

    /**
     * Show a single blog.
     */
    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show edit form.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update an existing blog.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $data = $request->validated();
        $blog->update($data);

        if ($request->hasFile('image')) {
            $blog->clearMediaCollection('blogs');
            try {
                $blog->addMediaFromRequest('image')
                    ->toMediaCollection('blogs');
            } catch (FileDoesNotExist|FileIsTooBig $e) {

            }
        }

        // AI SEO refresh
        if (empty($data['meta_keywords']) || empty($data['meta_description'])) {
            $seo = $this->aiService->generate($blog->title, $blog->detail);
            $blog->update([
                'meta_keywords'    => $seo['keywords'],
                'meta_description' => $seo['description'],
            ]);
        }

        return response()->json(['message' => 'Blog updated']);
    }

    /**
     * Soft-delete.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return response()->json(['message' => 'Blog deleted']);
    }

    /**
     * Restore from trash.
     */
    public function restore($id)
    {
        $blog = Blog::onlyTrashed()->findOrFail($id);
        $blog->restore();
        return response()->json(['message' => 'Blog restored']);
    }
}
