<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\WasteCategory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure some WasteCategories exist (idempotent)
        $plasticCategory = WasteCategory::firstOrCreate(
            ['name' => 'Plastic'],
            ['description' => 'Recyclable plastic materials', 'recycling_instructions' => 'Sort by type and clean before recycling']
        );
        $paperCategory = WasteCategory::firstOrCreate(
            ['name' => 'Paper'],
            ['description' => 'Paper and cardboard waste', 'recycling_instructions' => 'Flatten boxes and remove tape']
        );
        $metalCategory = WasteCategory::firstOrCreate(
            ['name' => 'Metal'],
            ['description' => 'Ferrous and non-ferrous metals', 'recycling_instructions' => 'Separate from other waste']
        );

        // Seed Products
        Product::create([
            'name' => 'Recycled Plastic Bottle Holder',
            'description' => 'Durable holder made from recycled PET plastic',
            'price' => 12.99,
            'stock_quantity' => 150,
            'waste_category_id' => $plasticCategory->id,
            'recycling_process_id' => null,
            'image_path' => '/images/product-bottle-holder.jpg',
            'specifications' => json_encode([
                'Size' => 'Standard',
                'Material' => 'Recycled PET',
                'Color' => 'Transparent'
            ]),
            'is_available' => true,
        ]);

        Product::create([
            'name' => 'Upcycled Paper Notebook',
            'description' => 'Eco-friendly notebook from recycled paper',
            'price' => 8.50,
            'stock_quantity' => 200,
            'waste_category_id' => $paperCategory->id,
            'recycling_process_id' => null,
            'image_path' => '/images/product-notebook.jpg',
            'specifications' => json_encode([
                'Pages' => 100,
                'Binding' => 'Spiral',
                'Cover' => 'Recycled Cardboard'
            ]),
            'is_available' => true,
        ]);

        Product::create([
            'name' => 'Metal Scrap Sculpture',
            'description' => 'Artistic sculpture crafted from recycled metals',
            'price' => 45.00,
            'stock_quantity' => 50,
            'waste_category_id' => $metalCategory->id,
            'recycling_process_id' => null,
            'image_path' => '/images/product-sculpture.jpg',
            'specifications' => json_encode([
                'Height' => '12 inches',
                'Weight' => '2.5 lbs',
                'Finish' => 'Rustic'
            ]),
            'is_available' => true,
        ]);

        // Add more generic products to reach ~15
        $categories = [$plasticCategory->id, $paperCategory->id, $metalCategory->id];
        for ($i = 4; $i <= 15; $i++) {
            Product::create([
                'name' => "Eco Product $i",
                'description' => "Sustainable product made from recycled materials #$i",
                'price' => 15.00 + ($i * 0.50),
                'stock_quantity' => 100 - ($i * 5),
                'waste_category_id' => $categories[($i - 1) % 3],
                'recycling_process_id' => null,
                'image_path' => "/images/product-$i.jpg",
                'specifications' => json_encode([
                    'Durability' => 'High',
                    'Eco Rating' => '5/5'
                ]),
                'is_available' => true,
            ]);
        }
    }
}