<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$servername = $_ENV['DB_HOST'];
$database   = $_ENV['DB_NAME'];
$username   = $_ENV['DB_USER'];
$password   = $_ENV['DB_PASS'];

try {
    $dbConn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode([
        "status" => "error",
        "message" => "Error de conexión: " . $e->getMessage()
    ]));
}
?>

