<?php
session_start();
require('../conexion/conexion.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../seleccion.php");
    exit();
}

$stmt = $pdo->query("SELECT p.*, c.nombre as categoria 
                     FROM producto p
                     LEFT JOIN categorias c ON p.categoria_id = c.id");

$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Libros</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 p-10">

<h1 class="text-3xl font-bold mb-6">Administrar Libros</h1>

<a href="agregar_libro.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded transition shadow-md">
    + Agregar Libro
</a>

<div class="overflow-hidden rounded-lg shadow-lg mt-6">
    <table class="w-full bg-white">
        <thead>
            <tr class="bg-slate-800 text-white">
                <th class="p-4 text-left">ID</th>
                <th class="p-4 text-left">Título</th>
                <th class="p-4 text-left">Precio</th>
                <th class="p-4 text-left">Categoría</th>
                <th class="p-4 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($libros as $libro): ?>
            <tr class="border-b hover:bg-slate-50 transition-colors">
                <td class="p-4 text-slate-600 font-mono text-sm"><?= $libro['id'] ?></td>
                <td class="p-4 font-semibold text-slate-700"><?= $libro['titulo'] ?></td>
                <td class="p-4 text-green-600 font-bold">$<?= number_format($libro['precio'], 2) ?></td>
                <td class="p-4">
                    <span class="bg-slate-200 text-slate-700 px-2 py-1 rounded text-xs uppercase">
                        <?= $libro['categoria'] ?>
                    </span>
                </td>
                <td class="p-4">
                    <div class="flex justify-center gap-3">
                        <a href="editar_libro.php?id=<?= $libro['id'] ?>" 
                           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1.5 rounded text-sm transition">
                            Editar
                        </a>

                        <a href="eliminar_libro.php?id=<?= $libro['id'] ?>" 
                           class="bg-red-500 hover:bg-red-600 text-white px-4 py-1.5 rounded text-sm transition"
                           onclick="return confirm('¿Seguro que quieres eliminar este libro?')">
                            Eliminar
                        </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="mt-10">
    <a href="../index.php" class="text-slate-500 hover:text-blue-600 transition underline flex items-center gap-2">
        <span>←</span> Volver al Inicio
    </a>
</div>

</body>
</html>