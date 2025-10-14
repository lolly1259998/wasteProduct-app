@extends('back.layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 to-teal-100 dark:from-zinc-800 dark:to-zinc-900">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 text-green-700 dark:text-green-300 text-center">Conseils IA Déchets ♻️</h1>

        <div class="max-w-md mx-auto bg-white dark:bg-zinc-800 p-6 rounded shadow-md">
            <!-- Formulaire IA -->
            <form action="{{ route('ai.advice.recycling') }}" method="POST">

                @csrf

                <div>
                    <label class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">Type de déchet</label>
                    <input type="text" name="type" class="form-control w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">Catégorie</label>
                    <input type="text" name="category" class="form-control w-full border rounded px-3 py-2" required>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Obtenir un conseil</button>
                </div>
            </form>

            <!-- Affichage conseil IA -->
           @if(isset($advice))
    <div class="mt-6 p-4 bg-green-100 ...">
        <h2>Conseil IA : {{ $advice }}</h2>
    </div>
@endif

        </div>
    </div>
</div>
@endsection
