<?php
session_start();
// 1. Salimos de 'auth' para entrar a la carpeta 'conexion'
require '../conexion/conexion.php'; 

$email = $_POST['email'];
$uid = $_POST['uid'];
$rol = $_POST['rol'];

// Decidimos la tabla según el rol
$tabla = ($rol === 'trabajador') ? 'trabajador' : 'usuarios';

// Nota: PHP permite variables en los nombres de tabla solo si son seguras como esta
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
?>