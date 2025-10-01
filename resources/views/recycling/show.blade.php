@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold">Processus #{{ $process->id }}</h1>
        <a href="{{ route('recycling.index') }}" class="px-4 py-2 rounded border">Retour</a>
    </div>

    @if(session('status'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('status') }}</div>
    @endif

    <div class="grid md:grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold mb-2">Détails du processus</h2>
            <div><strong>Méthode:</strong> {{ $process->method }}</div>
            <div><strong>Statut:</strong> {{ $process->status }}</div>
            <div><strong>Début:</strong> {{ $process->start_date }}</div>
            <div><strong>Fin:</strong> {{ $process->end_date }}</div>
            <div><strong>Quantité:</strong> {{ $process->output_quantity }}</div>
            <div><strong>Qualité:</strong> {{ $process->output_quality }}</div>
            <div><strong>Responsable:</strong> {{ optional($process->responsibleUser)->name }}</div>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <h2 class="font-semibold mb-2">Déchet</h2>
            <div><strong>ID:</strong> #{{ $process->waste_id }}</div>
            <div><strong>Type:</strong> {{ optional($process->waste)->type }}</div>
            <div><strong>Catégorie:</strong> {{ optional(optional($process->waste)->category)->name }}</div>
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow mt-4">
        <h2 class="font-semibold mb-2">Produits créés</h2>
        <ul class="list-disc list-inside">
            @forelse($process->products as $product)
                <li>{{ $product->name }} — {{ $product->price }} (stock: {{ $product->stock_quantity }})</li>
            @empty
                <li>Aucun produit</li>
            @endforelse
        </ul>

        @if($process->status !== 'completed')
            <a href="{{ route('recycling.complete', $process) }}" class="inline-block mt-3 bg-green-600 text-white px-3 py-2 rounded">Terminer</a>
        @endif
    </div>
</div>
@endsection

