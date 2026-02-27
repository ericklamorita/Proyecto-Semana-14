<?php
session_start();
date_default_timezone_set('America/Costa_Rica');
require('conexion/conexion.php');

if (!isset($_SESSION['usuario_id'])) exit();

$usuario_id = $_SESSION['usuario_id'];
$accion = $_GET['accion'];
$fecha = date('Y-m-d');
$hora = date('H:i:s');

if ($accion == 'entrada') {
    // Validar duplicidad [cite: 38]
    $check = $pdo->prepare("SELECT id FROM asistencias WHERE usuario_id = ? AND fecha = ?");
    $check->execute([$usuario_id, $fecha]);
    if (!$check->fetch()) {
        $sql = "INSERT INTO asistencias (usuario_id, uid_firebase, fecha, hora_entrada) VALUES (?, 'N/A', ?, ?)";
        $pdo->prepare($sql)->execute([$usuario_id, $fecha, $hora]);
    }
} elseif ($accion == 'salida') {
    // Actualizar salida 
    $sql = "UPDATE asistencias SET hora_salida = ? WHERE usuario_id = ? AND fecha = ? AND hora_salida IS NULL";
    $pdo->prepare($sql)->execute([$hora, $usuario_id, $fecha]);
}

header("Location: index.php");