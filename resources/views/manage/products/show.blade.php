<h1>Product #{{ $product->id }}</h1>
<p>Name: {{ $product->name }}</p>
<p>Category: {{ $product->category?->name }}</p>
<p>Price: {{ $product->price }}</p>
<p>Stock: {{ $product->stock_quantity }}</p>
<p>Description: {{ $product->description }}</p>
<a href="{{ route('manage.products.edit', $product) }}">Edit</a>

