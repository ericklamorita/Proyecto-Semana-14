<?php
session_start();
require 'conexion/conexion.php'; // Tu archivo de conexión PDO

$email = $_POST['email'];
$uid = $_POST['uid'];
$rol = $_POST['rol'];

// Decidimos la tabla según el rol
$tabla = ($rol === 'trabajador') ? 'trabajador' : 'usuarios';

$stmt = $pdo->prepare("SELECT id, nombre FROM $tabla WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user) {
    $_SESSION['usuario_id'] = $user['id'];
    $_SESSION['nombre'] = $user['nombre'];
    $_SESSION['rol'] = $rol;
    
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}