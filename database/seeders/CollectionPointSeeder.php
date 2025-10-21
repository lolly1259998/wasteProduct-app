<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CollectionPoint;

class CollectionPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        CollectionPoint::create(['id' => 1, 'name' => 'Main Collection Point', 'address' => 'City Center', 'status' => 'active']);
    }
    }

