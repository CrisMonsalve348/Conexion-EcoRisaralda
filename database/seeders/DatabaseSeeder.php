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


     User::factory()->create([
           'name' => 'Test User2',
           'last_name'=>'apellido2',
           'Country'=>'Colombia',
           'date_of_birth'=>'2025-10-02',
           'email_verified_at'=>now(),
            'password' => Hash::make('password123'),
            'role'=>'user',
            'email' => 'test2@example.com',

        ]
    
    
    );
    User::factory()->create([
           'name' => 'Test User3',
           'last_name'=>'apellido3',
           'Country'=>'Colombia',
           'date_of_birth'=>'2025-10-02',
           'email_verified_at'=>now(),
            'password' => Hash::make('password123'),
            'role'=>'user',
            'email' => 'test3@example.com',

        ]
    
    
    );
     User::factory()->create([
           'name' => 'Test User4',
           'last_name'=>'apellido4',
           'Country'=>'Colombia',
           'date_of_birth'=>'2025-10-02',
           'email_verified_at'=>now(),
            'password' => Hash::make('password123'),
            'role'=>'admin',
            'email' => 'test4@example.com',

        ]
    
    
    );
    }
}
