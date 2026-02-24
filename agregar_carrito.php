<?php
session_start();

if (isset($_POST['producto_id'])) {
    $id = $_POST['producto_id'];
    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $inicio = $_POST['fecha_inicio'];
    $fin = $_POST['fecha_fin'];
    $total = $_POST['total_pago'];

    // Si el carrito no existe, lo creamos
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Agregamos el libro como un arreglo dentro del carrito
    $_SESSION['carrito'][] = [
        'id' => $id,
        'titulo' => $titulo,
        'precio_dia' => $precio,
        'inicio' => $inicio,
        'fin' => $fin,
        'total' => $total
    ];

    header("Location: carrito.php");
    exit();
}