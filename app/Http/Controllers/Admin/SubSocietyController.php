<?php

// app/Http/Controllers/Admin/SubSocietyController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Society;
use App\Models\SubSociety;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

/**
 * Class SubSocietyController
 *
 * @package App\Http\Controllers\Admin
 */
class SubSocietyController extends Controller
{
    /**
     * List all SubSocieties.
     */
    public function index(): View
    {
        $subsocieties = SubSociety::with('society')
            ->latest()
            ->paginate(20);

        return view('admin.subsocieties.index', compact('subsocieties'));
    }

    /**
     * Show creation form.
     */
    public function create(): View
    {
        $societies = Society::orderBy('name')->get();
        return view('admin.subsocieties.create', compact('societies'));
    }

    /**
     * Store new SubSociety (with image).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'society_id'      => 'required|exists:societies,id',
            'name'            => 'required|string|max:255',
            'slug'            => 'required|string|max:255|unique:sub_societies,slug',
            'type'            => 'nullable|string|max:255',
            'meta_keywords'   => 'nullable|string|max:255',
            'meta_detail'     => 'nullable|string|max:255',
            'detail'          => 'nullable|string',
            'subsociety_image'=> 'nullable|image|max:10240', // up to 10MB
        ]);

        $sub = SubSociety::create($data);

        // Handle featured image if provided
        if ($request->hasFile('subsociety_image')) {
            try {
                $sub->addMediaFromRequest('subsociety_image')
                    ->toMediaCollection('subsociety_image');
            } catch (FileDoesNotExist|FileIsTooBig $e) {

            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'SubSociety created!',
                'id'      => $sub->id,
            ]);
        }

        return redirect()
            ->route('admin.subsocieties.index')
            ->with('success', 'SubSociety created successfully.');
    }

    /**
     * Show edit form.
     */
    public function edit(SubSociety $subsociety): View
    {
        $societies = Society::orderBy('name')->get();
        return view('admin.subsocieties.edit', compact('subsociety', 'societies'));
    }

    /**
     * Update existing SubSociety.
     */
    public function update(Request $request, SubSociety $subsociety)
    {
        $data = $request->validate([
            'society_id'      => 'required|exists:societies,id',
            'name'            => 'required|string|max:255',
            'slug'            => 'required|string|max:255|unique:sub_societies,slug,'.$subsociety->id,
            'type'            => 'nullable|string|max:255',
            'meta_keywords'   => 'nullable|string|max:255',
            'meta_detail'     => 'nullable|string|max:255',
            'detail'          => 'nullable|string',
            'subsociety_image'=> 'nullable|image|max:10240',
        ]);

        $subsociety->update($data);

        // Replace featured image if new one uploaded
        if ($request->hasFile('subsociety_image')) {
            $subsociety->clearMediaCollection('subsociety_image');
            try {
                $subsociety->addMediaFromRequest('subsociety_image')
                    ->toMediaCollection('subsociety_image');
            } catch (FileDoesNotExist|FileIsTooBig $e) {

            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'SubSociety updated!',
            ]);
        }

        return redirect()
            ->route('admin.subsocieties.index')
            ->with('success', 'SubSociety updated successfully.');
    }

    /**
     * Soft-delete.
     */
    public function destroy(SubSociety $subsociety)
    {
        $subsociety->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Deleted!']);
        }

        return redirect()
            ->route('admin.subsocieties.index')
            ->with('success', 'Deleted successfully.');
    }

    /**
     * Restore a soft deleted society.
     * @param int $id
     * @return JsonResponse
     */
    public function restore(int $id): JsonResponse
    {
        $subs = SubSociety::withTrashed()->findOrFail($id);
        $subs->restore();
        return response()->json(['message' => 'SubSociety restored.']);
    }

    /**
     * Get all subsocieties for a given society (for dependent dropdown).
     *
     * @param int $societyId
     * @return JsonResponse
     */
    public function getBySociety(int $societyId): JsonResponse
    {
        $subs = SubSociety::where('society_id', $societyId)->select('id','name')->orderBy('name')->get();
        return response()->json($subs);
    }
}

