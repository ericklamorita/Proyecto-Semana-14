<?php
require('conexion/conexion.php');

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM producto WHERE id=?");
$stmt->execute([$id]);

header("Location: admin_libros.php");
?>