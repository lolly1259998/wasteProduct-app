@extends('manage.layout')

@section('title','Edit Product')

@section('content')
<form method="POST" action="{{ route('manage.products.update', $product) }}" class="mx-auto max-w-2xl space-y-4 rounded-xl border border-gray-700 bg-gray-800/60 p-6">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm text-gray-300">Name</label>
        <input class="mt-1 w-full rounded-lg border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100" type="text" name="name" value="{{ old('name', $product->name) }}" />
    </div>
    <div>
        <label class="block text-sm text-gray-300">Category</label>
        <select class="mt-1 w-full rounded-lg border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100" name="category_id">
            <option value="">--</option>
            @foreach($categories as $id => $name)
                <option value="{{ $id }}" @selected(old('category_id', $product->category_id)==$id)>{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label class="block text-sm text-gray-300">Price</label>
            <input class="mt-1 w-full rounded-lg border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100" type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" />
        </div>
        <div>
            <label class="block text-sm text-gray-300">Stock</label>
            <input class="mt-1 w-full rounded-lg border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100" type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" />
        </div>
    </div>
    <div>
        <label class="block text-sm text-gray-300">Description</label>
        <textarea class="mt-1 w-full rounded-lg border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100" name="description">{{ old('description', $product->description) }}</textarea>
    </div>
    <div class="flex justify-end gap-2">
        <a href="{{ route('manage.products.index') }}" class="rounded-lg border border-gray-600 px-4 py-2 text-sm text-gray-200">Cancel</a>
        <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-black hover:bg-indigo-500">Update</button>
    </div>
</form>
@endsection

