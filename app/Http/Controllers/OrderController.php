<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    private static $products = [
        1 => ['name' => 'Product A', 'price' => 10.00],
        2 => ['name' => 'Product B', 'price' => 15.00],
        3 => ['name' => 'Product C', 'price' => 20.00],
    ];

    private function isFrontRoute()
    {
        return request()->route() && str_starts_with(request()->route()->getName(), 'front.');
    }

    private function getViewPrefix()
    {
        return $this->isFrontRoute() ? 'front.' : 'back.';
    }

    private function getRoutePrefix()
    {
        return $this->isFrontRoute() ? 'front.' : 'back.';
    }

    private function getPrefixedRoute($baseName)
    {
        return $this->getRoutePrefix() . $baseName;
    }

    private function getIndexRoute()
    {
        return $this->getPrefixedRoute('orders.index');
    }

    private function getCreateRoute()
    {
        return $this->getPrefixedRoute('orders.create');
    }

    private function getStoreRoute()
    {
        return $this->getPrefixedRoute('orders.store');
    }

    private function getShowRoute($order = null)
    {
        $name = $this->getPrefixedRoute('orders.show');
        return $order ? route($name, $order) : $name;
    }

    private function getEditRoute($order = null)
    {
        $name = $this->getPrefixedRoute('orders.edit');
        return $order ? route($name, $order) : $name;
    }

    private function getUpdateRoute($order = null)
    {
        $name = $this->getPrefixedRoute('orders.update');
        return $order ? route($name, $order) : $name;
    }

    private function getDestroyRoute($order = null)
    {
        $name = $this->getPrefixedRoute('orders.destroy');
        return $order ? route($name, $order) : $name;
    }

    public function index()
    {
        $query = Order::with('user')
            ->when(request('date_from'), function ($query) {
                return $query->where('order_date', '>=', request('date_from'));
            })
            ->when(request('date_to'), function ($query) {
                return $query->where('order_date', '<=', request('date_to'));
            })
            ->when(request('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when(request('product_search'), function ($query, $search) {
                $matchingProductIds = collect(self::$products)
                    ->filter(function ($product, $id) use ($search) {
                        return str_contains(strtolower($product['name']), strtolower($search));
                    })
                    ->keys()
                    ->toArray();
                return $query->whereIn('product_id', $matchingProductIds);
            });

        $orders = $query->paginate(4);  // Paginate with 12 items per page

        $viewPrefix = $this->getViewPrefix();
        $createRoute = $this->getCreateRoute();
        return view($viewPrefix . 'orders.index', compact('orders', 'createRoute'));
    }
    public function create()
    {
        $products = self::$products;
        $viewPrefix = $this->getViewPrefix();
        $storeRoute = $this->getStoreRoute();
        $indexRoute = $this->getIndexRoute();
        return view($viewPrefix . 'orders.create', compact('products', 'storeRoute', 'indexRoute'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', Rule::in(array_keys(self::$products))],
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:cash,card,transfer',
            'user_id' => 'required|exists:users,id',
        ]);

        $order = Order::create(array_merge($validated, [
            'status' => OrderStatus::Pending,
            'total_amount' => $validated['quantity'] * self::$products[$validated['product_id']]['price'],
            'order_date' => now(),
        ]));

        $indexRoute = $this->getIndexRoute();
        return redirect()->route($indexRoute)->with('success', 'Order created successfully!');
    }

    public function show(Order $order)
    {
        $order->load('user');
        $viewPrefix = $this->getViewPrefix();
        $indexRoute = $this->getIndexRoute();
        $editRoute = $this->getEditRoute($order);
        $destroyRoute = $this->getDestroyRoute($order);
        return view($viewPrefix . 'orders.show', compact('order', 'indexRoute', 'editRoute', 'destroyRoute'));
    }

    public function edit(Order $order)
    {
        $order->load('user');
        $products = self::$products;
        $viewPrefix = $this->getViewPrefix();
        $updateRoute = $this->getUpdateRoute($order);
        $showRoute = $this->getShowRoute($order);
        return view($viewPrefix . 'orders.edit', compact('order', 'products', 'updateRoute', 'showRoute'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'product_id' => ['required', Rule::in(array_keys(self::$products))],
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:cash,card,transfer',
            'status' => ['required', Rule::enum(OrderStatus::class)],
            'tracking_number' => 'nullable|string|max:100',
        ]);

        $validated['total_amount'] = $validated['quantity'] * self::$products[$validated['product_id']]['price'];
        $order->update($validated);

        $indexRoute = $this->getIndexRoute();
        return redirect()->route($indexRoute)->with('success', 'Order updated!');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        $indexRoute = $this->getIndexRoute();
        return redirect()->route($indexRoute)->with('success', 'Order deleted!');
    }

    public static function getProductName($productId)
    {
        return self::$products[$productId]['name'] ?? 'N/A';
    }
}