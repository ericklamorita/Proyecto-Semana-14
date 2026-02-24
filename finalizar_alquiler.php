<?php
session_start();
require_once 'conexion/conexion.php';

// Verificamos que haya algo que alquilar
if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header("Location: catalogo.php");
    exit();
}

try {
    $pdo->beginTransaction(); // Para que se guarde todo o nada

    $usuario_id = $_SESSION['usuario_id']; // ID del cliente logueado

    $sql = "INSERT INTO alquileres (usuario_id, producto_id, fecha_inicio, fecha_fin, total_pago) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    foreach ($_SESSION['carrito'] as $item) {
        $stmt->execute([
            $usuario_id,
            $item['id'],
            $item['inicio'],
            $item['fin'],
            $item['total']
        ]);
    }

    $pdo->commit();
    unset($_SESSION['carrito']); // Limpiamos el carrito tras el éxito

    echo "<script>
            alert('¡Alquileres registrados con éxito!');
            window.location.href = 'mis_alquileres.php';
          </script>";

} catch (Exception $e) {
    $pdo->rollBack();
    die("Error al procesar el alquiler: " . $e->getMessage());
}