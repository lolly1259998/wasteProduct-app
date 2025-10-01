<?php

namespace App\Http\Controllers;

use App\Models\RecyclingProcess;
use App\Models\Waste;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RecyclingProcessController extends Controller
{
    public function index()
    {
        $processes = RecyclingProcess::with(['waste', 'responsibleUser'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('recycling.index', compact('processes'));
    }

    public function create()
    {
        $recyclableWastes = Waste::whereNull('id')
            ->get();

        // Prefer showing recyclable wastes
        $recyclableWastes = Waste::query()
            ->whereIn('status', ['pending', 'recyclable'])
            ->with(['category', 'user'])
            ->orderByDesc('created_at')
            ->get();

        return view('recycling.create', compact('recyclableWastes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waste_id' => ['required', 'exists:wastes,id'],
            'method' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $waste = Waste::findOrFail($validated['waste_id']);

        $process = RecyclingProcess::create([
            'waste_id' => $waste->id,
            'method' => $validated['method'],
            'status' => 'in_progress',
            'start_date' => now(),
            'responsible_user_id' => Auth::id(),
            'notes' => $validated['notes'] ?? null,
        ]);

        $waste->update(['status' => 'processing']);

        return Redirect::route('recycling.show', $process)->with('status', 'Processus démarré.');
    }

    public function show(RecyclingProcess $recycling)
    {
        $recycling->load(['waste.category', 'responsibleUser', 'products']);
        return view('recycling.show', ['process' => $recycling]);
    }

    public function complete(RecyclingProcess $recycling)
    {
        $recycling->load('waste.category');
        return view('recycling.complete', ['process' => $recycling]);
    }

    public function updateComplete(Request $request, RecyclingProcess $recycling)
    {
        $validated = $request->validate([
            'output_quantity' => ['nullable', 'numeric', 'min:0'],
            'output_quality' => ['nullable', 'string', 'max:255'],
            'product_name' => ['required', 'string', 'max:255'],
            'product_description' => ['nullable', 'string'],
            'product_price' => ['required', 'numeric', 'min:0'],
            'product_stock' => ['required', 'integer', 'min:0'],
        ]);

        $recycling->update([
            'status' => 'completed',
            'end_date' => now(),
            'output_quantity' => $validated['output_quantity'] ?? null,
            'output_quality' => $validated['output_quality'] ?? null,
        ]);

        // Create a product linked to the recycling process and the waste category
        $waste = $recycling->waste()->first();

        Product::create([
            'name' => $validated['product_name'],
            'description' => $validated['product_description'] ?? null,
            'price' => $validated['product_price'],
            'stock_quantity' => $validated['product_stock'],
            'waste_category_id' => $waste->waste_category_id,
            'recycling_process_id' => $recycling->id,
            'is_available' => ($validated['product_stock'] ?? 0) > 0,
        ]);

        $waste->update(['status' => 'recycled']);

        return Redirect::route('recycling.show', $recycling)->with('status', 'Processus terminé et produit créé.');
    }
}

