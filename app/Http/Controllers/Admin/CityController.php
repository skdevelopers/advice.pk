<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Society;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class CityController
 *
 * @package App\Http\Controllers
 *
 * Handles all CRUD operations for the City model.
 */
class CityController extends Controller
{
    /**
     * Display a listing of cities with optional AJAX response.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = City::query();

            $sort = $request->get('sort', 'id');
            $order = $request->get('order', 'asc');
            $query->orderBy($sort, $order);

            $perPage = $request->get('per_page', 50);

            if ($perPage === 'all') {
                // Don't paginate, just return all results
                $cities = $query->get();
                return response()->json([
                    'data'  => $cities,
                    'links' => [],
                    'meta'  => [
                        'current_page' => 1,
                        'last_page'    => 1,
                        'total'        => $cities->count(),
                    ]
                ]);
            }

            $cities = $query->paginate($perPage)->appends($request->query());

            return response()->json([
                'data'  => $cities->items(),
                'links' => $cities->linkCollection()->toArray(),
                'meta'  => [
                    'current_page' => $cities->currentPage(),
                    'last_page'    => $cities->lastPage(),
                    'total'        => $cities->total(),
                ]
            ]);
        }
        return view('admin.cities.index');
    }

    /**
     * Show the form for creating a new city.
     */
    public function create()
    {
        return view('admin.cities.create');
    }

    /**
     * Store a newly created city in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:cities,slug',
            'status' => 'required|in:enabled,disabled',
        ]);

        City::create($request->only('name', 'slug', 'status'));

        return redirect()->route('admin.cities.index')->with('success', 'City created successfully.');
    }

    /**
     * Show the form for editing the specified city.
     */
    public function edit(Request $request, City $city)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'id'     => $city->id,
                'name'   => $city->name,
                'slug'   => $city->slug,
                'status' => $city->status,
            ]);
        }

        return view('admin.cities.edit', compact('city'));
    }

    /**
     * Update the specified city in storage.
     */
    public function update(Request $request, City $city)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'slug'   => 'required|string|max:255|unique:cities,slug,' . $city->id,
            'status' => 'required|in:enabled,disabled',
        ]);

        $city->update($request->only('name', 'slug', 'status'));

        if ($request->ajax()) {
            return response()->json(['message' => 'City updated successfully.']);
        }

        return redirect()->route('admin.cities.index')->with('success', 'City updated successfully.');
    }

    /**
     * Remove the specified city from storage.
     */
    public function destroy(City $city)
    {
        $city->delete();
        return redirect()->route('admin.cities.index')->with('success', 'City deleted successfully.');
    }

    /**
     * Display the specified city.
     *
     * @param  int  $id
     * @param Request $request
     * @return View|JsonResponse
     */
    public function show(int $id, Request $request)
    {
        $city = City::findOrFail($id);

        if ($request->ajax() || $request->has('ajax')) {
            return response()->json([
                'id'     => $city->id,
                'name'   => $city->name,
                'slug'   => $city->slug,
                'status' => $city->status,

            ]);
        }

        return view('admin.cities.show', compact('city'));
    }

}

