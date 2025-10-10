@extends('back.layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-200 text-center">waste_categories</h1>
        
        <!-- Single Add Button Below Title -->
        <div class="text-center mb-6">
            <a href="{{ route('waste_categories.create') }}" class="btn btn-success p-2 rounded-full hover:bg-green-600 transition duration-150 ease-in-out">
                <x-heroicon-o-plus class="h-5 w-5 text-white" />
            </a>
        </div>

        <!-- Success Message with Auto-Hide -->
        @if (session('success'))
            <div id="success-message" class="mb-4 p-3 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 rounded text-center">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    document.getElementById('success-message').style.display = 'none';
                }, 3000); // Hide after 3 seconds
            </script>
        @endif

        <!-- Tableau des catégories -->
        <div class="table-responsive">
            <table class="table table-striped table-hover custom-green-table">
                <thead>
                    <tr class="table-success">
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Instructions de Recyclage</th>
                        <th>Tableau de Bord</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr class="table-success">
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                @if($category->recycling_instructions)
                                    {{ $category->recycling_instructions }}
                                @else
                                    <span class="text-danger">Aucune instruction disponible</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('back.home') }}" class="btn btn-info btn-sm">Voir Tableau de Bord</a>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('waste_categories.edit', $category->id) }}" class="btn btn-primary btn-sm">
                                        <x-heroicon-o-pencil class="h-4 w-4" />
                                    </a>
                                    <form action="{{ route('waste_categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                                            <x-heroicon-o-trash class="h-4 w-4" />
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .custom-green-table {
        --bs-table-bg: #d4edda; /* Fond vert clair */
        --bs-table-striped-bg: #c3e6cb; /* Rayures vertes claires */
        --bs-table-hover-bg: #c3e6cb; /* Survol vert clair */
    }
    .table-success {
        background-color: #c3e6cb !important; /* Vert pour en-tête et lignes */
    }
</style>
@endsection