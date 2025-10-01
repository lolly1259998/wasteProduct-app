<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Waste; 
class WasteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $wastes=Waste::all();
        return view('waste.list',compact('wastes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('waste.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'weight' => 'required|numeric',
            'status' => 'required|in:recyclable,reusable',
            'user_id' => 'required|exists:users,id',
            'waste_category_id' => 'required|exists:waste_categories,id',
            
            'image_path' => 'nullable|string',
            'description' => 'required|string',
        ]);
        $data = $validated;

    
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('wastes', 'public');
        $data['image_path'] = $imagePath;
    }
        $data['collection_point_id'] = 2;
        Waste::create($data);
        return redirect()->route('wastes.index')->with('success', 'Waste created successfully');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $waste = Waste::findOrFail($id);
        return view('wastes.show', compact('waste'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
         $waste = Waste::findOrFail($id);
        return view('waste.edit', compact('waste'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validated = $request->validate([
            'type' => 'required|string|max:255',
            'weight' => 'required|numeric',
            'status' => 'required|in:recyclable,reusable',
            'user_id' => 'required|exists:users,id',
            'waste_category_id' => 'required|exists:waste_categories,id',
            'collection_point_id' => 'required|exists:collection_points,id',
            'image_path' => 'nullable|string',
            'description' => 'required|string',
        ]);

        $waste = Waste::findOrFail($id);
        $waste->update($validated);

        return redirect()->route('wastes.index')->with('success', 'Waste updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $waste = Waste::findOrFail($id);
        $waste->delete();   
        return redirect()->route('wastes.index')->with('success', 'Waste deleted successfully');
    }
}
