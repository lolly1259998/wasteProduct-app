<?php

namespace App\Services;

use App\Models\Product;
use App\Models\User;
use Phpml\Association\Apriori;

class RecommendationService
{
    private array $products = [];

    public function __construct()
    {
        // Load products from DB on instantiation (cached if needed; add caching for prod)
        $this->products = Product::available()  // Use scope if defined; else Product::where('is_available', true)->get()
            ->get()
            ->mapWithKeys(function ($product) {
                return [
                    $product->id => [
                        'name' => $product->name,
                        'price' => $product->price,
                        'related_waste' => $product->waste_category_id ?? 'general',  // Assume relation; adjust if needed
                    ]
                ];
            })
            ->toArray();
    }

    public function suggestForUser(User $user, int $limit = 3): array
    {
        // Get user history: donations (waste_ids) + past orders/reservations (product_ids)
        $pastWaste = $user->donations->pluck('waste_id')->toArray();
        $pastProducts = $user->orders->pluck('product_id')->merge($user->reservations->pluck('product_id'))->toArray();

        if (empty($pastWaste) && empty($pastProducts) || empty($this->products)) {
            // Fallback: Return first N products from DB
            return array_slice(array_values($this->products), 0, $limit, true);
        }

        // Train simple Apriori on history (associations like waste1 → product2)
        $transactions = $this->buildTransactions($pastWaste, $pastProducts);
        $apriori = new Apriori(0.5, 0.5);  // Support/confidence thresholds
        $apriori->train($transactions, array_keys($this->products));  // Items: product IDs from DB

        // Predict next
        $recommendations = $apriori->predict($pastProducts ?: [array_key_first($this->products)]);  // Seed with first ID if empty
        $suggestions = [];
        foreach ($recommendations as $productId) {
            if (isset($this->products[$productId])) {
                $suggestions[] = $this->products[$productId];  // Numeric push
                if (count($suggestions) >= $limit) break;
            }
        }

        // Ensure numeric if needed (fallback to DB products)
        if (empty($suggestions)) {
            $suggestions = array_slice(array_values($this->products), 0, $limit, true);
        }

        return $suggestions;
    }

    private function buildTransactions(array $wasteIds, array $productIds): array
    {
        // Simple: Map waste to potential products (expand with your logic)
        $transactions = [];
        foreach (array_merge($wasteIds, $productIds) as $item) {
            $transactions[] = [$item];  // Each as a "basket"
        }
        return $transactions;
    }
}
