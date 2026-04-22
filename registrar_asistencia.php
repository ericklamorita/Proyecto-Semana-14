<?php
session_start();
// La conexión está en la carpeta 'conexion/', entramos directo
require 'conexion/conexion.php';

// SEGURIDAD: Si no hay sesión, mandamos a la selección inicial
if (!isset($_SESSION['usuario_id'])) {
    header("Location: seleccion.php");
    exit();
}

$trabajador_id = $_SESSION['usuario_id'];
// Establecemos la zona horaria para que la marca sea exacta 
date_default_timezone_set('America/Costa_Rica'); 

$fecha_hoy = date('Y-m-d');
$hora_actual = date('H:i:s');
$accion = $_GET['accion'] ?? '';

if ($accion == 'entrada') {
    // Verificamos si ya marcó entrada hoy para evitar duplicados
    $sql_check = "SELECT * FROM asistencias WHERE trabajador_id = ? AND fecha = ?";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$trabajador_id, $fecha_hoy]);
    $existe = $stmt_check->fetch();

    if (!$existe) {
        $sql = "INSERT INTO asistencias (trabajador_id, fecha, hora_entrada, estado) VALUES (?, ?, ?, 'Presente')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$trabajador_id, $fecha_hoy, $hora_actual]);
    }
} elseif ($accion == 'salida') {
    // Actualizamos la hora de salida donde aún sea NULL para el día de hoy
    $sql = "UPDATE asistencias SET hora_salida = ? WHERE trabajador_id = ? AND fecha = ? AND hora_salida IS NULL";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$hora_actual, $trabajador_id, $fecha_hoy]);
}

// Redirigimos de vuelta al panel principal que está en la raíz
header("Location: index.php");
exit();