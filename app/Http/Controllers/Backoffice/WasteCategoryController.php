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
        $categories = WasteCategory::all();
        return view('wastecategory.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('wastecategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required', 
                'max:10', 
                'regex:/^[a-zA-Z\s\-]+$/',
                'unique:waste_categories,name'
            ],
            'description' => [
                'required', 
                'max:10', 
                'regex:/^[a-zA-Z\s\-\.,!?()]+$/'
            ],
            'recycling_instructions' => [
                'required', 
                'max:10', 
                'regex:/^[a-zA-Z\s\-\.,!?()]+$/'
            ],
        ], [
            'name.required' => 'Category name is required.',
            'name.max' => 'Name must not exceed 10 characters.',
            'name.regex' => 'Name can only contain letters, spaces and hyphens & Numbers are not allowed.',
            'name.unique' => 'This category already exists.',
            
            'description.required' => 'Description is required.',
            'description.max' => 'Description must not exceed 10 characters.',
            'description.regex' => 'Description can only contain letters, spaces and the following special characters & Numbers are not allowed.',
            
            'recycling_instructions.required' => 'Recycling instructions are required.',
            'recycling_instructions.max' => 'Instructions must not exceed 10 characters.',
            'recycling_instructions.regex' => 'Instructions can only contain letters, spaces and the following special characters & Numbers are not allowed.',
        ]);

        // Additional validation to prevent empty strings and numbers
        $this->validateNoEmptyAndNoNumbers($request);

        WasteCategory::create($validated);

        return redirect()->route('waste_categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = WasteCategory::findOrFail($id);
        return view('waste_categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = WasteCategory::findOrFail($id);
        return view('wastecategory.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = WasteCategory::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required', 
                'max:10', 
                'regex:/^[a-zA-Z\s\-]+$/',
                'unique:waste_categories,name,' . $id
            ],
            'description' => [
                'required', 
                'max:10', 
                'regex:/^[a-zA-Z\s\-\.,!?()]+$/'
            ],
            'recycling_instructions' => [
                'required', 
                'max:10', 
                'regex:/^[a-zA-Z\s\-\.,!?()]+$/'
            ],
        ], [
            'name.required' => 'Category name is required.',
            'name.max' => 'Name must not exceed 10 characters.',
            'name.regex' => 'Name can only contain letters, spaces and hyphens. Numbers are not allowed.',
            'name.unique' => 'This category already exists.',
            
            'description.required' => 'Description is required.',
            'description.max' => 'Description must not exceed 10 characters.',
            'description.regex' => 'Description can only contain letters, spaces and the following special characters & Numbers are not allowed.',
            
            'recycling_instructions.required' => 'Recycling instructions are required.',
            'recycling_instructions.max' => 'Instructions must not exceed 10 characters.',
            'recycling_instructions.regex' => 'Instructions can only contain letters, spaces and the following special characters & Numbers are not allowed.',
        ]);

        // Additional validation to prevent empty strings and numbers
        $this->validateNoEmptyAndNoNumbers($request);

        $category->update($validated);

        return redirect()->route('waste_categories.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = WasteCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('waste_categories.index')->with('success', 'Category deleted successfully');
    }

    /**
     * Additional validation to prevent empty strings and numbers in all fields
     */
    private function validateNoEmptyAndNoNumbers(Request $request)
    {
        $fields = [
            'name' => 'Name',
            'description' => 'Description', 
            'recycling_instructions' => 'Recycling instructions'
        ];
        
        foreach ($fields as $field => $fieldName) {
            // Check for empty strings (only spaces)
            if (trim($request->$field) === '') {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    $field => "$fieldName cannot be empty or contain only spaces."
                ]);
            }
            
            // Check for any numbers in all fields
            if (preg_match('/\d/', $request->$field)) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    $field => "$fieldName cannot contain numbers. Only letters and special characters are allowed."
                ]);
            }
        }
    }
}