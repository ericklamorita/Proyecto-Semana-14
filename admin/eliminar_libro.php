<?php
require('../conexion/conexion.php');

$id = $_GET['id'];

// La lógica del DELETE se mantiene exactamente igual
$stmt = $pdo->prepare("DELETE FROM producto WHERE id=?");
$stmt->execute([$id]);


header("Location: admin_libros.php");
exit(); // Es buena práctica poner exit() después de un header Location
?>