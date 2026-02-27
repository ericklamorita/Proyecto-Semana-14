<?php
session_start();
require_once 'conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $producto_id = $_POST['producto_id'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $total_pago = $_POST['total_pago'];

    try {
        $sql = "INSERT INTO alquileres (usuario_id, producto_id, fecha_inicio, fecha_fin, total_pago) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuario_id, $producto_id, $fecha_inicio, $fecha_fin, $total_pago]);

        // Redirigir con mensaje de éxito
        echo "<script>
                alert('¡Felicidades! Tu libro ha sido reservado en Villa de Libros.');
                window.location.href = 'catalogo.php';
              </script>";
    } catch (PDOException $e) {
        die("Error al procesar el alquiler: " . $e->getMessage());
    }
}