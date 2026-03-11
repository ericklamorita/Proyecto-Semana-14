<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturamos los datos del formulario
    $nuevo_item = [
        'id'           => $_POST['producto_id'],
        'titulo'       => $_POST['titulo'],
        'precio_dia'   => $_POST['precio'],
        'fecha_inicio' => $_POST['fecha_inicio'], // Clave importante
        'fecha_fin'    => $_POST['fecha_fin'],    // Clave importante
        'total'        => (float)$_POST['total_pago']
    ];

    // Verificamos que las fechas no vengan vacías antes de agregar
    if (empty($nuevo_item['fecha_inicio']) || empty($nuevo_item['fecha_fin'])) {
        echo "<script>
                alert('Por favor, seleccione un rango de fechas válido.');
                window.history.back();
              </script>";
        exit();
    }

    // Inicializamos el carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Añadimos el libro al carrito
    $_SESSION['carrito'][] = $nuevo_item;

    // Redirigimos al carrito para ver el resultado
    header("Location: carrito.php");
    exit();
} else {
    header("Location: ../catalogo.php");
    exit();
}