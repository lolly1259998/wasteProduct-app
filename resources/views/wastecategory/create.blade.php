@extends('back.layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 to-teal-100 dark:from-zinc-800 dark:to-zinc-900">
    <div class="container py-8">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h1 class="text-2xl font-bold mb-6 text-green-700 dark:text-green-300 text-center">Add New Category ♻️</h1>
                        @if ($errors->any())
                            <div class="mb-4 p-3 bg-red-100 dark:bg-red-900 border-l-2 border-red-500 dark:border-red-700 text-red-700 dark:text-red-200 rounded">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="mb-4 p-3 bg-green-100 dark:bg-green-900 border-l-2 border-green-500 dark:border-green-700 text-green-700 dark:text-green-200 rounded">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('waste_categories.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <!-- Nom de la catégorie -->
                            <div class="mb-3">
                                <label for="name" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Nom</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Description</label>
                                <textarea name="description" id="description" rows="3" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Instructions de Recyclage -->
                            <div class="mb-3">
                                <label for="recycling_instructions" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Instructions de Recyclage</label>
                                <textarea name="recycling_instructions" id="recycling_instructions" rows="2" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>{{ old('recycling_instructions') }}</textarea>
                                @error('recycling_instructions')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Boutons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('waste_categories.index') }}" class="btn btn-secondary btn-md">Cancel</a>
                                <button type="submit" class="btn btn-success btn-md">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection