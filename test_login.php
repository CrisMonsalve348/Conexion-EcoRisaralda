<?php
require __DIR__ . '/vendor/autoload.php';

// Inicializar Laravel
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

// Crear una solicitud simulada POST /api/login
$request = \Illuminate\Http\Request::create(
    '/api/login',
    'POST',
    [],
    [],
    [],
    ['CONTENT_TYPE' => 'application/json'],
    json_encode([
        'email' => 'admin@ecorisaralda.com',
        'password' => 'ecorisaralda123'
    ])
);

// Ejecutar la solicitud a través del kernel
$response = $kernel->handle($request);

// Mostrar resultado
echo "Status Code: " . $response->getStatusCode() . "\n";
echo "Response Content:\n";
echo $response->getContent() . "\n";

// Limpiar
$kernel->terminate($request, $response);
