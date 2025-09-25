<?php
$servername = "localhost";
$database = "datos";
$username = "root";
$password = "";

try {
    $dbConn = new PDO("mysql:host=$servername;dbname=$database;charset=utf8", $username, $password);
    $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
