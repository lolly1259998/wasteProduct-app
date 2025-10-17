<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('product')->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = \App\Models\Product::all();
        return view('orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
                'total_amount' => 'required|numeric|min:0',
                'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
                'order_date' => 'required|date',
                'shipping_address' => 'required|string',
                'payment_method' => 'required|string',
                'tracking_number' => 'nullable|string',
            ]);

            Order::create($validated);
            return redirect()->route('orders.index')->with('success', 'Order created!');
        } catch (\Exception $e) {
            Log::error('Order creation failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create order. Please try again.']);
        }
    }

    public function show(Order $order)
    {
        $order->load('product');
        return view('orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return redirect()->route('orders.index')->with('success', 'Order deleted!');
        } catch (\Exception $e) {
            Log::error('Order deletion failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to delete order. Please try again.']);
        }
    }
}