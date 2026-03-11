<?php
// 1. Ajuste de ruta: salimos de 'admin' para buscar la carpeta 'conexion'
require('../conexion/conexion.php');

$id = $_GET['id'];

// La lógica del DELETE se mantiene exactamente igual
$stmt = $pdo->prepare("DELETE FROM producto WHERE id=?");
$stmt->execute([$id]);

// 2. Redirección: como admin_libros.php está en la misma carpeta, 
// se queda tal cual.
header("Location: admin_libros.php");
exit(); // Es buena práctica poner exit() después de un header Location
?>