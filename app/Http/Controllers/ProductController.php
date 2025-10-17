<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'waste_category_id' => 'required|in:1,2,3,4',
                'recycling_process_id' => 'required|in:1,2,3,4',
                'image_path' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
                'specifications' => 'nullable|json',
                'is_available' => 'boolean',
            ]);

            if ($request->hasFile('image_path')) {
                $validated['image_path'] = $request->file('image_path')->store('products', 'public');
            }

            $validated['is_available'] = $request->input('is_available', 0) == 1;

            Product::create($validated);
            return redirect()->route('products.index')->with('success', 'Product created!');
        } catch (\Exception $e) {
            Log::error('Product creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create product. Please try again.']);
        }
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
                'waste_category_id' => 'required|in:1,2,3,4',
                'recycling_process_id' => 'required|in:1,2,3,4',
                'image_path' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
                'specifications' => 'nullable|json',
                'is_available' => 'boolean',
            ]);

            if ($request->hasFile('image_path')) {
                $validated['image_path'] = $request->file('image_path')->store('products', 'public');
            }

            $validated['is_available'] = $request->input('is_available', 0) == 1;

            $product->update($validated);
            return redirect()->route('products.index')->with('success', 'Product updated!');
        } catch (\Exception $e) {
            Log::error('Product update failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update product. Please try again.']);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Product deleted!');
        } catch (\Exception $e) {
            Log::error('Product deletion failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to delete product. Please try again.']);
        }
    }
}