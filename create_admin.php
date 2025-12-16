<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->boot();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'name' => 'Admin',
    'email' => 'admin@ecorisaralda.com',
    'password' => Hash::make('ecorisaralda123'),
    'role' => 'admin',
    'status' => 'active',
    'email_verified_at' => now(),
    'Country' => 'Colombia',
    'date_of_birth' => '1990-01-01'
]);

echo "✓ Admin creado exitosamente!\n";
echo "Email: admin@ecorisaralda.com\n";
echo "Contraseña: ecorisaralda123\n";
