@extends('manage.layout')

@section('title','Waste Categories')

@section('content')
<div class="mb-6 text-center relative z-10">
    <h2 class="text-2xl font-semibold">Waste Categories</h2>
    <div class="mt-4">
        <a href="{{ route('manage.categories.create') }}" wire:navigate aria-label="Create category"
           class="inline-flex items-center gap-2 rounded-full bg-emerald-600 px-4 py-2 text-sm font-semibold text-black shadow ring-2 ring-emerald-300 hover:bg-emerald-500">
            <span class="text-lg">+</span>
            <span>Create</span>
        </a>
    </div>
    <p class="mt-2 text-sm text-gray-400">Total: {{ $categories->total() }}</p>
    
    
</div>

<div class="grid grid-cols-1 gap-6 md:grid-cols-3">
    @foreach ($categories as $category)
        <div class="rounded-xl border border-gray-700 bg-gray-800/60 p-5 shadow-sm">
            <h3 class="text-lg font-semibold">
                <a href="{{ route('manage.categories.show', $category) }}" wire:navigate class="hover:underline">{{ $category->name }}</a>
            </h3>
            <p class="mt-1 line-clamp-2 text-sm text-gray-400">{{ $category->description }}</p>
            <div class="mt-4 flex items-center gap-2">
                <a href="{{ route('manage.categories.edit', $category) }}" wire:navigate class="inline-flex size-9 items-center justify-center rounded-full border border-gray-600 text-gray-200 hover:bg-gray-700" title="Edit">✏️</a>
                <a href="{{ route('manage.categories.show', $category) }}" wire:navigate class="inline-flex size-9 items-center justify-center rounded-full border border-gray-600 text-gray-200 hover:bg-gray-700" title="View">👁️</a>
                <form action="{{ route('manage.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?')" class="ml-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex size-9 items-center justify-center rounded-full border border-red-600 text-red-300 hover:bg-red-600/10" title="Delete">🗑️</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-6">{{ $categories->links() }}</div>

<!-- Floating Create Button (backup access) -->
<a href="{{ route('manage.categories.create') }}" wire:navigate aria-label="Create category"
   class="fixed bottom-8 right-8 inline-flex h-12 w-12 items-center justify-center rounded-full bg-emerald-600 text-white shadow-lg hover:bg-emerald-500">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
        <path fill-rule="evenodd" d="M12 4.5a1 1 0 0 1 1 1v5.5H18.5a1 1 0 1 1 0 2H13v5.5a1 1 0 1 1-2 0V13H5.5a1 1 0 1 1 0-2H11V5.5a1 1 0 0 1 1-1z" clip-rule="evenodd" />
    </svg>
</a>
@endsection

