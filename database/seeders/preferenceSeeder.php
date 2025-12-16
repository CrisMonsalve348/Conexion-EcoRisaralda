<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\preference;

class preferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $preferences = [
            [
                'name' => 'Senderismo (hiking)',
                'image' => 'hiking',
                'color' => 'FF6B6B',
            ],
            [
                'name' => 'Avistamiento de aves (birdwatching)',
                'image' => 'birdwatching',
                'color' => 'FFA500',
            ],
            [
                'name' => 'Ciclismo de montaña o ecológico',
                'image' => 'biking',
                'color' => '4ECDC4',
            ],
            [
                'name' => 'Escalada o rappel en roca natural',
                'image' => 'climbing',
                'color' => 'FFD93D',
            ],
            [
                'name' => 'Liberación de especies o voluntariado con fauna',
                'image' => 'wildlife',
                'color' => '6BCB77',
            ],
            [
                'name' => 'Visitas a reservas naturales o parques nacionales',
                'image' => 'reserves',
                'color' => '8B6F47',
            ],
            [
                'name' => 'Paseos en kayak o canoa',
                'image' => 'kayaking',
                'color' => '4D96FF',
            ],
            [
                'name' => 'Baños de bosque (forest bathing)',
                'image' => 'forest_bathing',
                'color' => '52B788',
            ],
        ];

        foreach($preferences as $preference){
            preference::firstOrCreate(
                ['name' => $preference['name']],
                [
                    'image' => $preference['image'],
                    'color' => $preference['color'],
                ]
            );
        }
    }
}
