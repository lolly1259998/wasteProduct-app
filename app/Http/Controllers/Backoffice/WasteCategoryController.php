<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WasteCategory; 

class WasteCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories=WasteCategory::all();
        return view('wastecategory.list',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('wastecategory.create');
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
        
        WasteCategory::create($validated);

        return redirect()->route('waste_categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $category = WasteCategory::findOrFail($id);
    return view('waste_categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $category = WasteCategory::findOrFail($id);
        return view('wastecategory.edit', compact('category'));
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

        return redirect()->route('waste_categories.index')->with('success', 'Category updated successfully');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = WasteCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('waste_categories.index')->with('success', 'Category deleted successfully');
    }
}
