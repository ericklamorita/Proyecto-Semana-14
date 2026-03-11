<?php
session_start();
require_once '../conexion/conexion.php';

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    header("Location: ../catalogo.php");
    exit();
}

try {
    $pdo->beginTransaction();

    if (!isset($_SESSION['usuario_id'])) {
        header("Location: ../auth/login.php");
        exit();
    }

    $usuario_id = $_SESSION['usuario_id']; 

    // Preparamos la consulta una sola vez para mayor eficiencia
    $sql = "INSERT INTO alquileres (usuario_id, producto_id, fecha_inicio, fecha_fin, total_pago) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    foreach ($_SESSION['carrito'] as $item) {
        // CORRECCIÓN: Aseguramos que las llaves coincidan con las del formulario
        // Usamos null coalescing (??) para evitar que envíe campos vacíos si la llave cambió
        $stmt->execute([
            $usuario_id,
            $item['id'] ?? $item['producto_id'],
            $item['fecha_inicio'] ?? $item['inicio'] ?? null,
            $item['fecha_fin'] ?? $item['fin'] ?? null,
            $item['total'] ?? $item['total_pago']
        ]);
    }

    $pdo->commit();
    unset($_SESSION['carrito']); // Limpiar carrito

    echo "<script>
            alert('¡Alquileres registrados con éxito!');
            window.location.href = '../catalogo.php'; 
          </script>";

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    // Mostramos un error más limpio
    die("Error al procesar el alquiler: Verifique que las fechas sean correctas. Detalle: " . $e->getMessage());
}