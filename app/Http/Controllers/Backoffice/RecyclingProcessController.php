<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\RecyclingProcess;
use App\Models\Waste;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecyclingProcessController extends Controller
{
    /**
     * Display a listing of the recycling processes.
     */
    public function index()
    {
        $recyclingProcesses = RecyclingProcess::with(['waste', 'waste.category', 'responsibleUser'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('back.recyclingprocesses.index', compact('recyclingProcesses'));
    }

    /**
     * Show the form for creating a new recycling process.
     */
    public function create()
    {
        // Récupérer uniquement les déchets qui n'ont pas encore de processus de recyclage
        $wastes = Waste::whereDoesntHave('recyclingProcess')
            ->with('category')
            ->get();
        
        $users = User::all();
        
        return view('back.recyclingprocesses.create', compact('wastes', 'users'));
    }

    /**
     * Store a newly created recycling process in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'waste_id' => 'required|exists:wastes,id|unique:recycling_processes,waste_id',
            'method' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed,failed',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'output_quantity' => 'nullable|numeric|min:0',
            'output_quality' => 'nullable|string|max:255',
            'responsible_user_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        // Si aucun utilisateur responsable n'est spécifié, utiliser l'utilisateur connecté
        if (!isset($validated['responsible_user_id'])) {
            $validated['responsible_user_id'] = Auth::id();
        }

        RecyclingProcess::create($validated);

        return redirect()->route('recyclingprocesses.index')
            ->with('success', 'Processus de recyclage créé avec succès.');
    }

    /**
     * Display the specified recycling process.
     */
    public function show($id)
    {
        $recyclingProcess = RecyclingProcess::with(['waste', 'waste.category', 'responsibleUser', 'products'])
            ->findOrFail($id);
        
        return view('back.recyclingprocesses.show', compact('recyclingProcess'));
    }

    /**
     * Show the form for editing the specified recycling process.
     */
    public function edit($id)
    {
        $recyclingProcess = RecyclingProcess::findOrFail($id);
        
        // Inclure le déchet actuel + les déchets sans processus
        $wastes = Waste::whereDoesntHave('recyclingProcess')
            ->orWhere('id', $recyclingProcess->waste_id)
            ->with('category')
            ->get();
        
        $users = User::all();
        
        return view('back.recyclingprocesses.edit', compact('recyclingProcess', 'wastes', 'users'));
    }

    /**
     * Update the specified recycling process in storage.
     */
    public function update(Request $request, $id)
    {
        $recyclingProcess = RecyclingProcess::findOrFail($id);
        
        $validated = $request->validate([
            'waste_id' => 'required|exists:wastes,id|unique:recycling_processes,waste_id,' . $id,
            'method' => 'required|string|max:255',
            'status' => 'required|in:pending,in_progress,completed,failed',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'output_quantity' => 'nullable|numeric|min:0',
            'output_quality' => 'nullable|string|max:255',
            'responsible_user_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $recyclingProcess->update($validated);

        return redirect()->route('recyclingprocesses.index')
            ->with('success', 'Processus de recyclage mis à jour avec succès.');
    }

    /**
     * Remove the specified recycling process from storage.
     */
    public function destroy($id)
    {
        $recyclingProcess = RecyclingProcess::findOrFail($id);
        
        // Vérifier si des produits sont liés à ce processus
        if ($recyclingProcess->products()->count() > 0) {
            return redirect()->route('recyclingprocesses.index')
                ->with('error', 'Impossible de supprimer ce processus car des produits y sont associés.');
        }
        
        $recyclingProcess->delete();

        return redirect()->route('recyclingprocesses.index')
            ->with('success', 'Processus de recyclage supprimé avec succès.');
    }
}

