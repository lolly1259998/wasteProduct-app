<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Waste; 
use App\Models\CollectionPoint;
class WasteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   /**
 * Display a listing of the resource.
 */
public function index(Request $request)
{
    // On crée une query builder pour le modèle Waste
    $query = Waste::query();

    // Si l'utilisateur a envoyé un terme de recherche
    if ($request->filled('search')) {
        $search = $request->input('search');

        $query->where('type', 'like', "%{$search}%")
              ->orWhereHas('category', function ($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%");
              });
    }

    // On récupère les résultats paginés
    $wastes = $query->paginate(10)->withQueryString();

    return view('waste.list', compact('wastes'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $collectionPoints = CollectionPoint::all();
        return view('waste.create', compact('collectionPoints'));
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
<<<<<<< HEAD
        $data['collection_point_id'] = $request->input('collection_point_id');
        Waste::create($data);
        return redirect()->route('wastes.index')->with('success', 'Waste created successfully');
=======

       $data['collection_point_id'] = $request->input('collection_point_id');
       Waste::create($data);
       return redirect()->route('wastes.index')->with('success', 'Waste created successfully');


>>>>>>> 36e93289263cd535f1fe8f26034c38bed54fcd40
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $waste = Waste::findOrFail($id);
        return view('waste.show', compact('waste'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
         $waste = Waste::findOrFail($id);
        $collectionPoints = CollectionPoint::all();
        return view('waste.edit', compact('waste', 'collectionPoints'));

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
