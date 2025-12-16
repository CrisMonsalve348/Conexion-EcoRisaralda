<?php
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Obtener la conexión PDO de Laravel
$pdo = DB::connection()->getPdo();

// Obtener el nombre de la BD desde config
$database = env('DB_DATABASE');

// Listar todas las tablas
$tables = $pdo->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$database'")->fetchAll(PDO::FETCH_COLUMN);

// Desactivar verificación de claves foráneas
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");

// Dropar todas las tablas
foreach ($tables as $table) {
    echo "Dropping table: $table\n";
    $pdo->exec("DROP TABLE IF EXISTS `$table`");
}

// Reactivar verificación
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

echo "All tables dropped successfully!\n";

// Ahora ejecutar las migraciones
echo "\nRunning migrations...\n";
$kernel->call('migrate');

echo "\nSeeding admin user...\n";
$kernel->call('db:seed', ['--class' => 'AdminSeeder']);

echo "\nDone!\n";
