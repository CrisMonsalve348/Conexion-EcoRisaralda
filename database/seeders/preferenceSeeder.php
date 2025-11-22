<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class preferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $preferences = [
    'Senderismo',
    'Avistamiento de Aves',
    'Ciclismo de Montaña',
    'Escaladismo',
    'Voluntariado Ambiental',
    'Visitas a Parques Naturales',
    'Paseo en canoa o kayak',
    'Bosquejo'
];

foreach ($preferences as $preference) {
    \App\Models\preferences::create([
        'name' => $preference,
    ]);
}

        foreach($preferences as $preference){
            \App\Models\preferences::firstOrCreate(['name' => $preference]);
        }
    }
}
