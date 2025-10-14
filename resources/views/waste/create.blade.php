@extends('back.layout')

@section('content')
<div class="min-vh-100 d-flex justify-content-center align-items-center" style="background-color: #f8f9fa;"> <!-- plain light background -->
    <div class="card shadow-lg p-4" style="max-width: 900px; width: 100%; border-radius: 1rem; background-color: #ffffff;">
        <h1 class="text-2xl font-bold mb-4 text-center text-green-700">Add a New Waste ♻️</h1>

        @if ($errors->any())
            <div class="mb-2 p-2 bg-red-100 border-l-2 border-red-500 text-red-700 rounded">
                <ul class="list-disc pl-4 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-2 p-2 bg-green-100 border-l-2 border-green-500 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('wastes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Row 1: Type | Weight | Status -->
            <div class="d-flex gap-2 mb-3">
                <div class="flex-fill">
                    <label for="type" class="form-label">Type</label>
                    <input type="text" name="type" id="type" value="{{ old('type') }}" class="form-control form-control-sm" required>
                </div>
                <div class="flex-fill">
                    <label for="weight" class="form-label">Weight (kg)</label>
                    <input type="number" step="0.01" name="weight" id="weight" value="{{ old('weight') }}" class="form-control form-control-sm" required>
                </div>
                <div class="flex-fill">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-control form-control-sm" required>
                        <option value="recyclable" {{ old('status') == 'recyclable' ? 'selected' : '' }}>Recyclable</option>
                        <option value="reusable" {{ old('status') == 'reusable' ? 'selected' : '' }}>Reusable</option>
                    </select>
                </div>
            </div>

            <!-- Row 2: User | Category | Collection Point -->
            <div class="d-flex gap-2 mb-3">
                <div class="flex-fill">
                    <label for="user_id" class="form-label">User</label>
                    <select name="user_id" id="user_id" class="form-control form-control-sm" required>
                        @foreach(\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-fill">
                    <label for="waste_category_id" class="form-label">Waste Category</label>
                    <select name="waste_category_id" id="waste_category_id" class="form-control form-control-sm" required>
                        @foreach(\App\Models\WasteCategory::all() as $category)
                            <option value="{{ $category->id }}" {{ old('waste_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-fill">
                    <label for="collection_point_id" class="form-label">Collection Point ID</label>
                    <input type="number" name="collection_point_id" id="collection_point_id" value="{{ old('collection_point_id') }}" class="form-control form-control-sm" required>
                </div>
            </div>

            <!-- Row 3: Image | Description -->
            <div class="d-flex gap-2 mb-3">
                <div class="flex-fill">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" id="image" class="form-control form-control-sm">
                </div>
                <div class="flex-fill">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="2" class="form-control form-control-sm" required>{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('wastes.index') }}" class="btn btn-secondary btn-sm">Cancel</a>
                <button type="submit" class="btn btn-success btn-sm">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
