<?php
$host = 'localhost';
$db   = 'libreria';   
$user = 'root';
$pass = 'Admin$1234';  
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=3306;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
