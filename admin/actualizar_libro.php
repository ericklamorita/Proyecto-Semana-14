<?php
// 1. Subimos un nivel (../) para salir de 'admin' y entrar a 'conexion'
require('../conexion/conexion.php');

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$imagen = $_POST['imagen'];
$categoria_id = $_POST['categoria_id'];

$sql = "UPDATE producto 
        SET titulo=?, descripcion=?, precio=?, imagen=?, categoria_id=?
        WHERE id=?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$titulo,$descripcion,$precio,$imagen,$categoria_id,$id]);

// 2. Como 'admin_libros.php' está en la misma carpeta 'admin', 
// no necesitas cambiar la ruta del Location, se queda igual.
header("Location: admin_libros.php");
?>