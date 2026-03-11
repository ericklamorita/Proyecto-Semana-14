<?php
session_start();
// 1. CORRECCIÓN: Subimos un nivel para encontrar la carpeta de conexión
require_once '../conexion/conexion.php';

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

        // 2. CORRECCIÓN: El script de redirección debe salir de la carpeta alquiler/
        // para encontrar el catalogo.php en la raíz.
        echo "<script>
                alert('¡Felicidades! Tu libro ha sido reservado en Villa de Libros.');
                window.location.href = '../catalogo.php';
              </script>";
        exit();
    } catch (PDOException $e) {
        die("Error al procesar el alquiler: " . $e->getMessage());
    }
}
?>