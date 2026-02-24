<?php
session_start();
require_once 'conexion/conexion.php';

$usuario_id = $_SESSION['usuario_id'];
$stmt = $pdo->prepare("SELECT a.*, p.titulo, p.imagen FROM alquileres a 
                       JOIN producto p ON a.producto_id = p.id 
                       WHERE a.usuario_id = ? ORDER BY a.id DESC");
$stmt->execute([$usuario_id]);
$alquileres = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Alquileres | Villa de Libros</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 p-10">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-slate-800">📚 Mi Historial de Lectura</h1>
            <a href="catalogo.php" class="bg-cyan-500 text-white px-4 py-2 rounded-lg font-bold">Volver al Catálogo</a>
        </div>

        <div class="grid gap-6">
            <?php foreach ($alquileres as $alq): ?>
            <div class="bg-white p-6 rounded-2xl shadow-md flex items-center gap-6 border-l-8 border-cyan-400">
                <img src="<?php echo $alq['imagen']; ?>" class="w-20 h-28 object-cover rounded-lg shadow">
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-slate-800"><?php echo $alq['titulo']; ?></h2>
                    <p class="text-slate-500 italic">Periodo: <?php echo $alq['fecha_inicio']; ?> al <?php echo $alq['fecha_fin']; ?></p>
                </div>
                <div class="text-right text-lg font-extrabold text-cyan-600">
                    $<?php echo $alq['total_pago']; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>