<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Waste;

class FrontWasteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $wastes = Waste::all();
        return view('front.wastes.index', compact('wastes'));
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('front.wastes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0.01',
            'waste_category_id' => 'required|exists:waste_categories,id',
            'user_id' => 'required|exists:users,id',
        
            'status' => 'required|string|in:recyclable,reusable,non-recyclable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

  if ($request->hasFile('image')) {
        $path = $request->file('image')->store('images', 'public');
        $data['image_path'] = $path;
    }
    $data['collection_point_id'] = 2;

    Waste::create($data);

    return redirect()->route('front.wastes.index')->with('success', 'Waste created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $wastes = Waste::findOrFail($id);
        return view('front.wastes.show', compact('wastes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $wastes = Waste::findOrFail($id);
        return view('front.wastes.edit', compact('wastes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'weight' => 'required|numeric',
            'waste_category_id' => 'required|exists:waste_categories,id',
            'user_id' => 'required|exists:users,id',
            'collection_point_id' => 'required|exists:collection_points,id',
        ]);
        $wastes = Waste::findOrFail($id);
        $wastes->update($request->all());

        return redirect()->route('front.wastes.index')->with('success', 'Waste updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $wastes = Waste::findOrFail($id);
        $wastes->delete();
        return redirect()->route('front.wastes.index')->with('success', 'Waste deleted successfully');
    }
}
