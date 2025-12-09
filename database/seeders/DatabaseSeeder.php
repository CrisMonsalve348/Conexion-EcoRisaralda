<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
         $this->call(PreferenceSeeder::class);

        User::factory()->create([
           'name' => 'Test User',
           'last_name'=>'apellido',
           'Country'=>'Colombia',
           'date_of_birth'=>'2025-10-02',
           'email_verified_at'=>now(),
            'password' => Hash::make('password123'),
            'role'=>'operator',
            'email' => 'test@example.com',

        ]
    
    
    );
    }
}
