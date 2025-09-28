<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WasteCategory;

class WasteCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        WasteCategory::create([
            "name"=>"Plastic",
            "description"=>"Waste made from plastic materials.",
            "recycling_instructions"=>"Clean and sort plastics before recycling."
        ]);
        WasteCategory::factory(5)->create();

    }
}
