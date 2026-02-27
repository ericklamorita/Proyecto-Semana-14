<?php
session_start();
require 'conexion/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: seleccion.php");
    exit();
}

$trabajador_id = $_SESSION['usuario_id'];
$fecha_hoy = date('Y-m-d');
$hora_actual = date('H:i:s');
$accion = $_GET['accion'];

if ($accion == 'entrada') {
    // Verificamos si ya marcó entrada hoy
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
    // Actualizamos la hora de salida usando trabajador_id
    $sql = "UPDATE asistencias SET hora_salida = ? WHERE trabajador_id = ? AND fecha = ? AND hora_salida IS NULL";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$hora_actual, $trabajador_id, $fecha_hoy]);
}

header("Location: index.php");
exit();
?>