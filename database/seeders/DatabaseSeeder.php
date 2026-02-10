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
         $this->call(CountrySeeder::class);
        // User::factory(10)->create();
        
        // Crear usuarios primero
        User::factory()->create([
           'name' => 'Test User',
           'last_name'=>'apellido',
           'country_id'=>'1',
           'date_of_birth'=>'2025-10-02',
           'email_verified_at'=>now(),
            'password' => Hash::make('password123'),
            'role'=>'operator',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
           'name' => 'Test User2',
           'last_name'=>'apellido2',
           'country_id'=>'1',
           'date_of_birth'=>'2025-10-02',
           'email_verified_at'=>now(),
            'password' => Hash::make('password123'),
            'role'=>'user',
            'email' => 'test2@example.com',
        ]);

        User::factory()->create([
           'name' => 'Test User3',
           'last_name'=>'apellido3',
           'country_id'=>'1',
           'date_of_birth'=>'2025-10-02',
           'email_verified_at'=>now(),
            'password' => Hash::make('password123'),
            'role'=>'user',
            'email' => 'test3@example.com',
        ]);

        User::factory()->create([
           'name' => 'Test User4',
           'last_name'=>'apellido4',
           'country_id'=>'1',
           'date_of_birth'=>'2025-10-02',
           'email_verified_at'=>now(),
            'password' => Hash::make('password123'),
            'role'=>'admin',
            'email' => 'test4@example.com',
        ]);

        // Luego ejecutar los seeders que dependen de usuarios
        $this->call(PreferenceSeeder::class);
        $this->call(TurusticPlaceSeeder::class);
    }
}
