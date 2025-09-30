@extends('front.layout')


@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6 text-gray-900 dark:text-gray-100">Waste Categories</h1>

    @if($categories->isEmpty())
        <p class="text-gray-500">No categories available yet.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <div class="bg-white dark:bg-zinc-800 shadow-md rounded-lg p-4">
                    <h2 class="text-xl font-semibold">{{ $category->name }}</h2>
                    <p class="text-gray-600 dark:text-gray-300">{{ $category->description }}</p>
                    <small class="text-gray-400">Instructions: {{ $category->recycling_instructions }}</small>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
