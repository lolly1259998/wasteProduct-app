<?php

namespace App\Http\Controllers;

use App\Enums\DonationStatus;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DonationController extends Controller
{
    private static $wasteTypes = [
        1 => ['name' => 'Plastic'],
        2 => ['name' => 'Paper'],
        3 => ['name' => 'Glass'],
    ];

    public function index()
    {
        $donations = Donation::with('user')->get();
        return view('donations.index', compact('donations'));
    }

    public function create()
    {
        $wastes = self::$wasteTypes;
        return view('donations.create', compact('wastes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waste_id' => ['required', Rule::in(array_keys(self::$wasteTypes))],
            'item_name' => 'required|string|max:255',
            'condition' => 'required|string|in:new,used,damaged',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048',
            'pickup_required' => 'boolean',
            'pickup_address' => 'required_if:pickup_required,true|string|nullable|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('donations', 'public');
            }
            $validated['images'] = $imagePaths;
        }

        $donation = Donation::create($validated + ['status' => DonationStatus::Available]);
        return redirect()->route('donations.index')->with('success', 'Donation created!');
    }

    public function show(Donation $donation)
    {
        return view('donations.show', compact('donation'));
    }

    public function destroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('donations.index')->with('success', 'Donation deleted!');
    }

    public static function getWasteTypeName($wasteId)
    {
        return self::$wasteTypes[$wasteId]['name'] ?? 'N/A';
    }
}