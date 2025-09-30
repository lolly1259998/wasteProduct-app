@extends('front.layout')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center text-success">Waste List</h1>

    <div class="mb-4 text-right">
        <a href="{{ route('front.wastes.create') }}" class="btn btn-success">+ Add Waste</a>
    </div>

    @if($wastes->isEmpty())
        <p class="text-muted text-center">No wastes available yet.</p>
    @else
        <div class="row">
            @foreach($wastes as $waste)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-success text-center">{{ $waste->type }}</h5>
                            <p class="card-text"><strong>Weight:</strong> {{ $waste->weight }} kg</p>
                            <p class="card-text"><strong>Status:</strong> {{ $waste->status }}</p>
                            <p class="card-text"><strong>Category:</strong> {{ $waste->category->name ?? 'N/A' }}</p>
                            <small class="text-muted mb-3">{{ $waste->description }}</small>

                            <div class="mt-auto d-flex justify-content-between">
                                <a href="{{ route('front.wastes.edit', $waste->id) }}" class="btn btn-primary btn-sm">Edit</a>

                                <form action="{{ route('front.wastes.destroy', $waste->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                        @if($waste->image_path)
                            <img src="{{ asset('storage/'.$waste->image_path) }}" class="card-img-bottom" alt="Waste Image">
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
