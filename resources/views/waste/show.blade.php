@extends('back.layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6 text-green-500 dark:text-green-400 text-center">Details For Wastes ♻️</h1>

        <div class="bg-white dark:bg-zinc-800 shadow-lg rounded-lg p-6">
           
        @if ($waste->image_path)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $waste->image_path) }}" alt="Waste Image" class="max-w-xs rounded-lg shadow-md">
                </div>
            @endif
             <p><strong>Point de Collecte :</strong> Main Collection Point</p>
            <p><strong>Type :</strong> {{ $waste->type }}</p>
            <p><strong>Poids :</strong> {{ $waste->weight }} kg</p>
            <p><strong>Statut :</strong> {{ $waste->status }}</p>
            <p><strong>Description :</strong> {{ $waste->description ?? 'No description' }}</p>
            <p><strong>Catégorie :</strong> {{ $waste->category->name ?? 'Unknown' }}</p>
            <p><strong>Utilisateur :</strong> {{ $waste->user->name ?? 'Unknown User' }}</p>
            
            <div class="mt-4">
                <a href="{{ route('wastes.index') }}" class="btn btn-secondary btn-md">Cancel</a>
            </div>
        </div>
    </div>
</div>
@endsection