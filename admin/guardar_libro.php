<?php
// 1. Salimos de 'admin' para buscar la carpeta 'conexion'
require('../conexion/conexion.php');

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$imagen = $_POST['imagen'];
$categoria_id = $_POST['categoria_id'];

$sql = "INSERT INTO producto (titulo, descripcion, precio, imagen, categoria_id)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $pdo->prepare($sql);
$stmt->execute([$titulo, $descripcion, $precio, $imagen, $categoria_id]);

// 2. CORRECCIÓN CLAVE: catalogo.php está en la raíz, 
// así que debemos usar ../ para salir de la carpeta 'admin'
header("Location: ../catalogo.php");
exit();
?>