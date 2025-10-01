@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4">Démarrer un processus de recyclage</h1>

    <form method="POST" action="{{ route('recycling.store') }}" class="space-y-4 bg-white p-4 rounded shadow">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Déchet</label>
            <select name="waste_id" class="w-full border rounded p-2" required>
                <option value="">-- Sélectionner --</option>
                @foreach($recyclableWastes as $waste)
                    <option value="{{ $waste->id }}">#{{ $waste->id }} - {{ $waste->type }} ({{ optional($waste->category)->name }})</option>
                @endforeach
            </select>
            @error('waste_id')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Méthode</label>
            <input type="text" name="method" class="w-full border rounded p-2" required />
            @error('method')
                <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Notes</label>
            <textarea name="notes" class="w-full border rounded p-2" rows="3"></textarea>
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">Démarrer</button>
            <a href="{{ route('recycling.index') }}" class="px-4 py-2 rounded border">Annuler</a>
        </div>
    </form>
</div>
@endsection

