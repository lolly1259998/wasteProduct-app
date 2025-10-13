@extends('back.layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-100 to-teal-100 dark:from-zinc-800 dark:to-zinc-900">
    <div class="container py-8">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h1 class="text-2xl font-bold mb-6 text-green-700 dark:text-green-300 text-center">Ajouter un Nouveau Déchet ♻️</h1>

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

                        <form action="{{ route('wastes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <!-- Type -->
                            <div class="mb-3">
                                <label for="type" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Type</label>
                                <input type="text" name="type" id="type" value="{{ old('type') }}" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                @error('type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Weight -->
                            <div class="mb-3">
                                <label for="weight" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Poids (kg)</label>
                                <input type="number" step="0.01" name="weight" id="weight" value="{{ old('weight') }}" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                @error('weight')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Statut</label>
                                <select name="status" id="status" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                    <option value="recyclable" {{ old('status') == 'recyclable' ? 'selected' : '' }}>Recyclable</option>
                                    <option value="reusable" {{ old('status') == 'reusable' ? 'selected' : '' }}>Reusable</option>
                                </select>
                                @error('status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- User -->
                            <div class="mb-3">
                                <label for="user_id" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Utilisateur</label>
                                <select name="user_id" id="user_id" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                    @foreach(\App\Models\User::all() as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Waste Category -->
                            <div class="mb-3">
                                <label for="waste_category_id" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Catégorie de Déchet</label>
                                <select name="waste_category_id" id="waste_category_id" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                    @foreach(\App\Models\WasteCategory::all() as $category)
                                        <option value="{{ $category->id }}" {{ old('waste_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('waste_category_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Collection Point ID -->
                            <div class="mb-3">
                                <label for="collection_point_id" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">ID Point de Collecte</label>
                                <input type="number" name="collection_point_id" id="collection_point_id" value="{{ old('collection_point_id') }}" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400" required>
                                @error('collection_point_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Image -->
                            <div class="mb-3">
                                <label for="image" class="form-label text-lg font-semibold text-gray-800 dark:text-gray-200">Image</label>
                                <input type="file" name="image" id="image" class="form-control bg-white dark:bg-zinc-700 text-gray-900 dark:text-gray-100 border-teal-300 dark:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-400 focus:border-teal-500 dark:focus:border-teal-400">
                                @error('image')
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

                            <!-- Boutons -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('wastes.index') }}" class="btn btn-secondary btn-md">Annuler</a>
                                <button type="submit" class="btn btn-success btn-md">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection