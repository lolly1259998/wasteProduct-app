@extends('manage.layout')

@section('title','Products')

@section('content')
<div class="mb-6 text-center">
    <h2 class="text-2xl font-semibold">Products</h2>
    <div class="mt-4">
        <a href="{{ route('manage.products.create') }}" wire:navigate class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-black hover:bg-indigo-500">
            <span class="text-lg">+</span>
            <span>Create</span>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 md:grid-cols-3">
    @foreach ($products as $product)
        <div class="rounded-xl border border-gray-700 bg-gray-800/60 p-5 shadow-sm">
            <h3 class="text-lg font-semibold">
                <a href="{{ route('manage.products.show', $product) }}" wire:navigate class="hover:underline">{{ $product->name }}</a>
            </h3>
            <p class="mt-1 text-sm text-gray-400">Category: {{ $product->category?->name ?? '—' }}</p>
            <p class="text-sm text-gray-400">Price: {{ $product->price }} | Stock: {{ $product->stock_quantity }}</p>
            <div class="mt-4 flex items-center gap-2">
                <a href="{{ route('manage.products.edit', $product) }}" wire:navigate class="inline-flex size-9 items-center justify-center rounded-full border border-gray-600 text-gray-200 hover:bg-gray-700" title="Edit">✏️</a>
                <a href="{{ route('manage.products.show', $product) }}" wire:navigate class="inline-flex size-9 items-center justify-center rounded-full border border-gray-600 text-gray-200 hover:bg-gray-700" title="View">👁️</a>
                <form action="{{ route('manage.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')" class="ml-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex size-9 items-center justify-center rounded-full border border-red-600 text-red-300 hover:bg-red-600/10" title="Delete">🗑️</button>
                </form>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-6">{{ $products->links() }}</div>
@endsection

