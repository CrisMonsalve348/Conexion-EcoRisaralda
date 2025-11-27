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
                'name' => 'Senderismo',
                'image' => 'hiking.png',
                'color' => 'D9D9D9',
            ],
            [
                'name' => 'Avistamiento de Aves',
                'image' => 'birdwatching.png',
                'color' => 'FED9A0',
            ],
            [
                'name' => 'Ciclismo de Montaña',
                'image' => 'bicycle.png',
                'color' => '96D471',
            ],
            [
                'name' => 'Escaladismo',
                'image' => 'rappelling.png',
                'color' => 'E6C675',
            ],
            [
                'name' => 'Voluntariado Ambiental',
                'image' => 'turtle.png',
                'color' => 'CEF3BD',
            ],
            [
                'name' => 'Visitas a Parques Naturales',
                'image' => 'national-park.png',
                'color' => 'DBB48E',
            ],
            [
                'name' => 'Paseo en canoa o kayak',
                'image' => 'kayaking.png',
                'color' => 'DBE9F5',
            ],
            [
                'name' => 'Bosquejo',
                'image' => 'forest.png',
                'color' => '6FBF6B',
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
