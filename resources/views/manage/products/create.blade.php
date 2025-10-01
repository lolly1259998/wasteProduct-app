@extends('manage.layout')

@section('title','New Product')

@section('content')
<form method="POST" action="{{ route('manage.products.store') }}" class="mx-auto max-w-2xl space-y-4 rounded-xl border border-gray-700 bg-gray-800/60 p-6">
    @csrf
    <div>
        <label class="block text-sm text-gray-300">Name</label>
        <input class="mt-1 w-full rounded-lg border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100" type="text" name="name" value="{{ old('name') }}" />
        @error('name')<div class="mt-1 text-sm text-red-400">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="block text-sm text-gray-300">Category</label>
        <select class="mt-1 w-full rounded-lg border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100" name="category_id">
            <option value="">--</option>
            @foreach($categories as $id => $name)
                <option value="{{ $id }}" @selected(old('category_id')==$id)>{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div>
            <label class="block text-sm text-gray-300">Price</label>
            <input class="mt-1 w-full rounded-lg border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100" type="number" step="0.01" name="price" value="{{ old('price') }}" />
        </div>
        <div>
            <label class="block text-sm text-gray-300">Stock</label>
            <input class="mt-1 w-full rounded-lg border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100" type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" />
        </div>
    </div>
    <div>
        <label class="block text-sm text-gray-300">Description</label>
        <textarea class="mt-1 w-full rounded-lg border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100" name="description">{{ old('description') }}</textarea>
    </div>
    <div class="flex justify-end gap-2">
        <a href="{{ route('manage.products.index') }}" class="rounded-lg border border-gray-600 px-4 py-2 text-sm text-gray-200">Cancel</a>
        <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-black hover:bg-indigo-500">Create</button>
    </div>
</form>
@endsection

