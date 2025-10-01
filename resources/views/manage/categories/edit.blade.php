@extends('manage.layout')

@section('title','Edit Category')

@section('content')
<form method="POST" action="{{ route('manage.categories.update', $category) }}" class="mx-auto max-w-xl space-y-4 rounded-xl border border-gray-700 bg-gray-800/60 p-6">
    @csrf
    @method('PUT')
    <div>
        <label class="block text-sm text-gray-300">Name</label>
        <input class="mt-1 w-full rounded-lg border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100" type="text" name="name" value="{{ old('name', $category->name) }}" />
        @error('name')<div class="mt-1 text-sm text-red-400">{{ $message }}</div>@enderror
    </div>
    <div>
        <label class="block text-sm text-gray-300">Description</label>
        <textarea class="mt-1 w-full rounded-lg border border-gray-600 bg-gray-900 px-3 py-2 text-gray-100" name="description">{{ old('description', $category->description) }}</textarea>
    </div>
    <div class="flex justify-end gap-2">
        <a href="{{ route('manage.categories.index') }}" class="rounded-lg border border-gray-600 px-4 py-2 text-sm text-gray-200">Cancel</a>
        <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-500">Update</button>
    </div>
</form>
@endsection

