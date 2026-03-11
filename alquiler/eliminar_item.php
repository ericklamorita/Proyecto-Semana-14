<?php
session_start();

// Obtenemos el índice que queremos borrar
$id_borrar = $_GET['id'] ?? null;

if ($id_borrar !== null && isset($_SESSION['carrito'][$id_borrar])) {
    // Eliminamos ese elemento del arreglo
    unset($_SESSION['carrito'][$id_borrar]);
    
    // Re-indexamos el arreglo para que no queden huecos
    // Esto es vital para que los próximos "quitar" no fallen
    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
}

// Como 'carrito.php' está en la misma carpeta 'alquiler', se queda así:
header("Location: carrito.php");
exit();
?>