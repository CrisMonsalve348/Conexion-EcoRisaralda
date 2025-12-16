<?php
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Ahora cargamos el modelo
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Crear o actualizar admin
$admin = User::updateOrCreate(
    ['email' => 'admin@ecorisaralda.com'],
    [
        'name' => 'Admin EcoRisaralda',
        'last_name' => 'Admin',
        'Country' => 'Colombia',
        'date_of_birth' => '1990-01-01',
        'password' => Hash::make('ecorisaralda123'),
        'role' => 'admin',
        'status' => 'active',
        'email_verified_at' => now(),
        'first_time_preferences' => true,
    ]
);

echo "Admin user created/updated successfully!\n";
echo "Email: " . $admin->email . "\n";
echo "Role: " . $admin->role . "\n";
echo "Status: " . $admin->status . "\n";
