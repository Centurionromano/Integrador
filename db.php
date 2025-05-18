<?php
$env_path = __DIR__ . '/.env';

if (!file_exists($env_path)) {
    die("❌ El archivo .env no existe en: $env_path");
}

$dotenv = parse_ini_file($env_path);
foreach ($dotenv as $key => $value) {
    putenv("$key=$value");
}

$host = getenv('MYSQLHOST');
$dbname = getenv('MYSQLDATABASE');
$username = getenv('MYSQLUSER');
$password = getenv('MYSQLPASSWORD');

try {
    $pdo = new PDO("mysql:host=$host;port=57120;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "✅ Conexión exitosa a la base de datos.";
} catch (PDOException $e) {
    echo '❌ Error de conexión: ' . $e->getMessage();
    exit();
}


