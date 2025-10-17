<?php

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Models\Product;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('product')->get();
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $products = Product::all();
        return view('reservations.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reserved_until' => 'required|date|after:now',
            'user_id' => 'required|exists:users,id',
        ]);

        $reservation = Reservation::create($validated + ['status' => ReservationStatus::Pending]);
        return redirect()->route('reservations.index')->with('success', 'Reservation created!');
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservation deleted!');
    }
}