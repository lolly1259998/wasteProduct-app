<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WasteCategory;

class FrontWasteCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = WasteCategory::all();
        return view('front.waste-categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('front.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => ['required', 'max:10', 'regex:/^[a-zA-Z0-9]+$/'],
            'description' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'recycling_instructions' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
        ]);

        $validated['recycling_instructions'] = $request->input('recycling_instructions', 'No instructions provided');

        WasteCategory::create($validated);

        return redirect()->route('front.waste-categories.index')->with('success', 'Category created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $category = WasteCategory::findOrFail($id);
        return view('front.waste-categories-show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $category = WasteCategory::findOrFail($id);
        return view('front.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
           'name' => ['required', 'max:10', 'regex:/^[a-zA-Z0-9]+$/'],
            'description' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'recycling_instructions' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
        ]);

        $category = WasteCategory::findOrFail($id);
        $category->update($validated);

        return redirect()->route('front.waste-categories.index')->with('success', 'Category updated successfully');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        return redirect()->route('front.waste-categories.index')->with('error', 'Deleting categories is only available in the backoffice.');
    }
}
