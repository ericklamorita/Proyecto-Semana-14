<?php
require('conexion/conexion.php');

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

header("Location: admin_libros.php");
?>