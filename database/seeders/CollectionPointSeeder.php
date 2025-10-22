<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CollectionPoint;

class CollectionPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collectionPoints = [
            [
                'name' => 'Centre de Collecte Tunis Nord',
                'address' => 'Rue de l’Environnement, Cité El Khadra',
                'city' => 'Tunis',
                'postal_code' => '1003',
                'latitude' => 36.8429,
                'longitude' => 10.1934,
                'opening_hours' => [
                    'lundi-vendredi' => '08:00 - 17:00',
                    'samedi' => '08:00 - 13:00',
                    'dimanche' => 'Fermé'
                ],
                'accepted_categories' => [1, 2, 3], // Ex: plastique, verre, papier
                'contact_phone' => '+216 71 234 567',
                'status' => 'actif',
            ],
            [
                'name' => 'ÉcoPoint Sfax Sud',
                'address' => 'Zone Industrielle, Route de Gabès',
                'city' => 'Sfax',
                'postal_code' => '3002',
                'latitude' => 34.7406,
                'longitude' => 10.7603,
                'opening_hours' => [
                    'lundi-samedi' => '07:30 - 18:00',
                    'dimanche' => 'Fermé'
                ],
                'accepted_categories' => [2, 4], // verre, métal
                'contact_phone' => '+216 74 567 890',
                'status' => 'actif',
            ],
            [
                'name' => 'Point Vert Ariana Centre',
                'address' => 'Avenue Habib Bourguiba',
                'city' => 'Ariana',
                'postal_code' => '2080',
                'latitude' => 36.8663,
                'longitude' => 10.1644,
                'opening_hours' => [
                    'lundi-vendredi' => '09:00 - 16:30',
                    'samedi' => '09:00 - 13:00',
                    'dimanche' => 'Fermé'
                ],
                'accepted_categories' => [1, 5], // plastique, électronique
                'contact_phone' => '+216 70 112 233',
                'status' => 'inactif',
            ],
        ];

        foreach ($collectionPoints as $point) {
            CollectionPoint::create($point);
        }
    }
}
