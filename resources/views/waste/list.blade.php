@extends('back.layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-zinc-900">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6 text-green-500 dark:text-green-400 text-center">Waste List ♻️</h1>

        <!-- Bouton Ajouter -->
        <div class="text-start mb-4 flex justify-between items-center">
            <div class="mb-4 flex justify-between items-center">
            <a href="{{ route('wastes.create') }}" 
               class="btn btn-success btn-md d-inline-flex align-items-center gap-2 px-4 py-2 rounded-pill shadow-sm">
                <x-heroicon-o-plus class="h-5 w-5 text-white" />
                <span>+</span>
            </a>
</div>
            <!-- Barre de recherche -->
          <div class="mb-4 flex justify-start items-center gap-2">
    <form action="{{ route('wastes.index') }}" method="GET" class="flex items-center gap-2">
        <!-- barre de recherche petite -->
        <input type="text" name="search" placeholder="Search by type or category"
               value="{{ request('search') }}"
               class="border rounded px-3 py-2" 
               style="width: 500px; height: 38px;"> <!-- même hauteur que le bouton -->

        <!-- bouton juste à côté -->
        <button type="submit" class="btn btn-primary px-4 py-2 rounded" style="height: 38px;">
            Search
        </button>
    </form>
</div>

        </div>

        <!-- Message de succès -->
        @if (session('success'))
            <div id="success-message" class="mb-4 p-3 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 rounded text-center">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(() => {
                    document.getElementById('success-message').style.display = 'none';
                }, 3000);
            </script>
        @endif

        <!-- Tableau -->
        <div class="table-responsive">
            <table class="table table-hover custom-green-table align-middle">
                <thead class="table-success text-center">
                    <tr>
                        <th>Type</th>
                        <th>Weight (kg)</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>User</th>
                        <th>Collection Point</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wastes as $waste)
                        <tr class="text-center">
                            <td>{{ $waste->type }}</td>
                            <td>{{ $waste->weight }}</td>
                            <td>{{ $waste->status }}</td>
                            <td>{{ $waste->description ?? 'No description' }}</td>
                            <td>{{ $waste->category->name ?? 'Unknown' }}</td>
                            <td>{{ $waste->user->name ?? 'Unknown User' }}</td>
                            <td>Main Collection Point</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('wastes.show', $waste->id) }}" 
                                       class="btn btn-info btn-sm p-2 shadow-sm"
                                       title="Afficher">
                                        Show
                                    </a>
                                    <a href="{{ route('wastes.edit', $waste->id) }}" 
                                       class="btn btn-primary btn-sm p-2 shadow-sm"
                                       title="Modifier">
                                        Edit
                                    </a>
                                    <form action="{{ route('wastes.destroy', $waste->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this waste?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-danger btn-sm p-2 shadow-sm"
                                                title="Supprimer">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="mt-4">
                {{ $wastes->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Style personnalisé -->
<style>
    .custom-green-table {
        --bs-table-bg: #e8f5e9;
        --bs-table-striped-bg: #dcedc8;
        --bs-table-hover-bg: #c8e6c9;
    }
    .btn-md {
        font-size: 0.95rem;
        padding: 0.45rem 0.9rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease-in-out;
    }
    .btn-md:hover {
        transform: scale(1.05);
    }
</style>
@endsection
