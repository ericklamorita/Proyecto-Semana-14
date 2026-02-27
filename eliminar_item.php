<?php
session_start();

// Obtenemos el índice que queremos borrar
$id_borrar = $_GET['id'] ?? null;

if ($id_borrar !== null && isset($_SESSION['carrito'][$id_borrar])) {
    // Eliminamos ese elemento del arreglo
    unset($_SESSION['carrito'][$id_borrar]);
    
    // Re-indexamos el arreglo para que no queden huecos
    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
}

header("Location: carrito.php");
exit();