<?php
require('conexion/conexion.php');

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$imagen = $_POST['imagen'];
$categoria_id = $_POST['categoria_id'];

$sql = "INSERT INTO producto (titulo, descripcion, precio, imagen, categoria_id)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([$titulo, $descripcion, $precio, $imagen, $categoria_id]);

header("Location: catalogo.php");
?>