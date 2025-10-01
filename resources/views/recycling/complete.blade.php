@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Terminer le processus #{{ $process->id }}</h1>

    <div class="bg-white rounded shadow p-4 mb-4">
        <div class="mb-2"><strong>Déchet:</strong> #{{ $process->waste_id }} - {{ optional($process->waste)->type }}</div>
        <div class="mb-2"><strong>Méthode:</strong> {{ $process->method }}</div>
        <div class="mb-2"><strong>Statut:</strong> {{ $process->status }}</div>
    </div>

    <form method="POST" action="{{ route('recycling.updateComplete', $process) }}" class="space-y-4 bg-white p-4 rounded shadow">
        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-medium">Quantité produite</label>
                <input type="number" step="0.01" name="output_quantity" class="w-full border rounded p-2" />
            </div>
            <div>
                <label class="block mb-1 font-medium">Qualité de sortie</label>
                <input type="text" name="output_quality" class="w-full border rounded p-2" />
            </div>
        </div>

        <h2 class="text-xl font-semibold mt-4">Produit à créer</h2>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-medium">Nom du produit</label>
                <input type="text" name="product_name" class="w-full border rounded p-2" required />
                @error('product_name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block mb-1 font-medium">Prix</label>
                <input type="number" step="0.01" name="product_price" class="w-full border rounded p-2" required />
                @error('product_price')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block mb-1 font-medium">Stock</label>
                <input type="number" name="product_stock" class="w-full border rounded p-2" required />
                @error('product_stock')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1 font-medium">Description</label>
                <textarea name="product_description" rows="3" class="w-full border rounded p-2"></textarea>
            </div>
        </div>

        <div class="flex gap-2">
            <button class="bg-green-600 text-white px-4 py-2 rounded" type="submit">Terminer</button>
            <a href="{{ route('recycling.index') }}" class="px-4 py-2 rounded border">Annuler</a>
        </div>
    </form>
</div>
@endsection

