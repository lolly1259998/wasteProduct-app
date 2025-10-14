<?php

namespace App\Http\Controllers;

use App\Enums\DonationStatus;
use App\Models\Donation;
use App\Models\User;
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
        return $this->getPrefixedRoute('donations.index');
    }

    private function getCreateRoute()
    {
        return $this->getPrefixedRoute('donations.create');
    }

    private function getStoreRoute()
    {
        return $this->getPrefixedRoute('donations.store');
    }

    private function getShowRoute($donation = null)
    {
        $name = $this->getPrefixedRoute('donations.show');
        return $donation ? route($name, $donation) : $name;
    }

    private function getEditRoute($donation = null)
    {
        $name = $this->getPrefixedRoute('donations.edit');
        return $donation ? route($name, $donation) : $name;
    }

    private function getUpdateRoute($donation = null)
    {
        $name = $this->getPrefixedRoute('donations.update');
        return $donation ? route($name, $donation) : $name;
    }

    private function getDestroyRoute($donation = null)
    {
        $name = $this->getPrefixedRoute('donations.destroy');
        return $donation ? route($name, $donation) : $name;
    }

    public function index()
    {
        $query = Donation::with('user')
            ->when(request('date_from'), function ($query) {
                return $query->where('created_at', '>=', request('date_from'));
            })
            ->when(request('date_to'), function ($query) {
                return $query->where('created_at', '<=', request('date_to') . ' 23:59:59');
            })
            ->when(request('item_search'), function ($query, $search) {
                return $query->where('item_name', 'like', '%' . $search . '%');
            })
            ->when(request('user_search'), function ($query, $search) {
                return $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->when(request('waste_id'), function ($query, $waste_id) {
                return $query->where('waste_id', $waste_id);
            })
            ->when(request('condition'), function ($query, $condition) {
                return $query->where('condition', $condition);
            })
            ->when(request('status'), function ($query, $status) {
                return $query->where('status', $status);
            });

        $donations = $query->paginate(12);  // Paginate with 12 items per page

        $wastes = self::$wasteTypes;

        $viewPrefix = $this->getViewPrefix();
        $createRoute = $this->getCreateRoute();
        return view($viewPrefix . 'donations.index', compact('donations', 'createRoute', 'wastes'));
    }
    public function create()
    {
        $wastes = self::$wasteTypes;
        $users = User::all();
        $viewPrefix = $this->getViewPrefix();
        $storeRoute = $this->getStoreRoute();
        $indexRoute = $this->getIndexRoute();
        return view($viewPrefix . 'donations.create', compact('wastes', 'users', 'storeRoute', 'indexRoute'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'waste_id' => ['required', Rule::in(array_keys(self::$wasteTypes))],
            'item_name' => 'required|string|max:255',
            'condition' => 'required|string|in:new,used,damaged',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048',
            'pickup_required' => 'nullable|boolean',
            'pickup_address' => 'required_if:pickup_required,true|string|nullable|max:255',
        ]);

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('donations', 'public');
            }
            $validated['images'] = $imagePaths;
        }

        $donation = Donation::create($validated + ['status' => DonationStatus::Available]);

        $indexRoute = $this->getIndexRoute();
        return redirect()->route($indexRoute)->with('success', 'Donation created successfully!');
    }

    public function show(Donation $donation)
    {
        $donation->load('user');
        $viewPrefix = $this->getViewPrefix();
        $indexRoute = $this->getIndexRoute();
        $editRoute = $this->getEditRoute($donation);
        $destroyRoute = $this->getDestroyRoute($donation);
        return view($viewPrefix . 'donations.show', compact('donation', 'indexRoute', 'editRoute', 'destroyRoute'));
    }

    public function edit(Donation $donation)
    {
        $donation->load('user');
        $wastes = self::$wasteTypes;
        $users = User::all();
        $viewPrefix = $this->getViewPrefix();
        $updateRoute = $this->getUpdateRoute($donation);
        $showRoute = $this->getShowRoute($donation);
        $indexRoute = $this->getIndexRoute();  // Add this line
        return view($viewPrefix . 'donations.edit', compact('donation', 'wastes', 'users', 'updateRoute', 'showRoute', 'indexRoute'));  // Add 'indexRoute' to compact
    }

    public function update(Request $request, Donation $donation)
    {
        // Base rules without status
        $rules = [
            'user_id' => 'required|exists:users,id',
            'waste_id' => ['required', Rule::in(array_keys(self::$wasteTypes))],
            'item_name' => 'required|string|max:255',
            'condition' => 'required|string|in:new,used,damaged',
            'description' => 'nullable|string',
            'images.*' => 'nullable|image|max:2048',
            'pickup_required' => 'nullable|boolean',
            'pickup_address' => 'required_if:pickup_required,true|string|nullable|max:255',
        ];

        // Add status rule only for back-end (admin) routes
        if (!$this->isFrontRoute()) {
            $rules['status'] = ['required', Rule::enum(DonationStatus::class)];
        }

        $validated = $request->validate($rules);

        // For front-end, preserve existing status if not provided
        if ($this->isFrontRoute() && !isset($validated['status'])) {
            $validated['status'] = $donation->status;
        }

        if ($request->hasFile('images')) {
            // Optionally delete old images if needed
            if ($donation->images && is_array($donation->images)) {
                foreach ($donation->images as $imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
            }
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('donations', 'public');
            }
            $validated['images'] = $imagePaths;
        }

        $donation->update($validated);

        $indexRoute = $this->getIndexRoute();
        return redirect()->route($indexRoute)->with('success', 'Donation updated!');
    }

    public function destroy(Donation $donation)
    {
        // Optionally delete images
        if ($donation->images && is_array($donation->images)) {
            foreach ($donation->images as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }
        $donation->delete();
        $indexRoute = $this->getIndexRoute();
        return redirect()->route($indexRoute)->with('success', 'Donation deleted!');
    }

    public static function getWasteTypeName($wasteId)
    {
        return self::$wasteTypes[$wasteId]['name'] ?? 'N/A';
    }
}