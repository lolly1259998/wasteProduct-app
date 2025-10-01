@extends('manage.layout')

@section('title','Category')

@section('content')
<div class="rounded-xl border border-gray-700 bg-gray-800/60 p-6">
    <h2 class="text-xl font-semibold">{{ $category->name }}</h2>
    <p class="mt-1 text-gray-400">{{ $category->description }}</p>
    <div class="mt-4">
        <a href="{{ route('manage.categories.edit', $category) }}" class="rounded-lg border border-gray-600 px-4 py-2 text-sm text-gray-200">Edit</a>
    </div>
</div>
@endsection

