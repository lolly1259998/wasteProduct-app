<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
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
        return $this->getPrefixedRoute('reservations.index');
    }

    private function getCreateRoute()
    {
        return $this->getPrefixedRoute('reservations.create');
    }

    private function getStoreRoute()
    {
        return $this->getPrefixedRoute('reservations.store');
    }

    private function getShowRoute($reservation = null)
    {
        $name = $this->getPrefixedRoute('reservations.show');
        return $reservation ? route($name, $reservation) : $name;
    }

    private function getEditRoute($reservation = null)
    {
        $name = $this->getPrefixedRoute('reservations.edit');
        return $reservation ? route($name, $reservation) : $name;
    }

    private function getUpdateRoute($reservation = null)
    {
        $name = $this->getPrefixedRoute('reservations.update');
        return $reservation ? route($name, $reservation) : $name;
    }

    private function getDestroyRoute($reservation = null)
    {
        $name = $this->getPrefixedRoute('reservations.destroy');
        return $reservation ? route($name, $reservation) : $name;
    }

    public function index()
    {
        $query = Reservation::with('user')
            ->when(request('date_from'), function ($query) {
                return $query->where('created_at', '>=', request('date_from'));
            })
            ->when(request('date_to'), function ($query) {
                return $query->where('created_at', '<=', request('date_to'));
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

        $reservations = $query->paginate(12);  // Paginate with 12 items per page

        $viewPrefix = $this->getViewPrefix();
        $createRoute = $this->getCreateRoute();
        return view($viewPrefix . 'reservations.index', compact('reservations', 'createRoute'));
    }

    public function create()
    {
        $products = self::$products;
        $viewPrefix = $this->getViewPrefix();
        $storeRoute = $this->getStoreRoute();
        $indexRoute = $this->getIndexRoute();
        return view($viewPrefix . 'reservations.create', compact('products', 'storeRoute', 'indexRoute'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', Rule::in(array_keys(self::$products))],
            'quantity' => 'required|integer|min:1',
            'reserved_until' => 'required|date|after:now',
            'user_id' => 'required|exists:users,id',
        ]);

        $reservation = Reservation::create($validated);

        $indexRoute = $this->getIndexRoute();
        return redirect()->route($indexRoute)->with('success', 'Reservation created successfully!');
    }

    public function show(Reservation $reservation)
    {
        $reservation->load('user');
        $viewPrefix = $this->getViewPrefix();
        $indexRoute = $this->getIndexRoute();
        $editRoute = $this->getEditRoute($reservation);
        $destroyRoute = $this->getDestroyRoute($reservation);
        return view($viewPrefix . 'reservations.show', compact('reservation', 'indexRoute', 'editRoute', 'destroyRoute'));
    }

    public function edit(Reservation $reservation)
    {
        $reservation->load('user');
        $products = self::$products;
        $viewPrefix = $this->getViewPrefix();
        $updateRoute = $this->getUpdateRoute($reservation);
        $showRoute = $this->getShowRoute($reservation);
        return view($viewPrefix . 'reservations.edit', compact('reservation', 'products', 'updateRoute', 'showRoute'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'product_id' => ['required', Rule::in(array_keys(self::$products))],
            'quantity' => 'required|integer|min:1',
            'reserved_until' => 'required|date|after:now',
            'status' => ['required', Rule::enum(ReservationStatus::class)],
        ]);

        $reservation->update($validated);

        $indexRoute = $this->getIndexRoute();
        return redirect()->route($indexRoute)->with('success', 'Reservation updated!');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        $indexRoute = $this->getIndexRoute();
        return redirect()->route($indexRoute)->with('success', 'Reservation deleted!');
    }

    public static function getProductName($productId)
    {
        return self::$products[$productId]['name'] ?? 'N/A';
    }
}