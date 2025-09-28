@extends('front.layout')

@section('content')
<div class="text-center mb-5">
    <h1 class="fw-bold text-success">Welcome to Waste2Product</h1>
    <p class="lead">Transforming waste into valuable products for a sustainable future.</p>
</div>

<!-- Sections -->
<div class="row text-center">
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow">
            <div class="card-body">
                <h5 class="card-title text-success">Recycling</h5>
                <p class="card-text">Discover how we recycle waste into reusable materials.</p>
                <a href="{{ url('/recycling') }}" class="btn btn-success">Learn More</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow">
            <div class="card-body">
                <h5 class="card-title text-success">Products</h5>
                <p class="card-text">Browse eco-friendly products made from recycled waste.</p>
                <a href="{{ url('/products') }}" class="btn btn-success">Shop Now</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow">
            <div class="card-body">
                <h5 class="card-title text-success">Donations</h5>
                <p class="card-text">Contribute to our mission by donating unused items.</p>
                <a href="{{ url('/donations') }}" class="btn btn-success">Donate</a>
            </div>
        </div>
    </div>
</div>
@endsection
