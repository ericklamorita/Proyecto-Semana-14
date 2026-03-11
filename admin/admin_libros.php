<?php
session_start();
// 1. Salimos de 'admin' para buscar 'conexion'
require('../conexion/conexion.php');

if (!isset($_SESSION['usuario_id'])) {
    // 2. 'seleccion.php' está en la raíz, así que subimos un nivel
    header("Location: ../seleccion.php");
    exit();
}

$stmt = $pdo->query("SELECT p.*, c.nombre as categoria 
                     FROM producto p
                     LEFT JOIN categorias c ON p.categoria_id = c.id");

$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Administrar Libros</title>
    <script src="https://cdn.tailwindcss.com"></script>
    </head>

<body class="bg-slate-100 p-10">

<h1 class="text-3xl font-bold mb-6">Administrar Libros</h1>

<a href="agregar_libro.php" class="bg-green-600 text-white px-4 py-2 rounded">
    Agregar Libro
</a>

<table class="w-full mt-6 bg-white shadow rounded">
    <tr class="bg-slate-800 text-white">
        <th class="p-2">ID</th>
        <th>Titulo</th>
        <th>Precio</th>
        <th>Categoria</th>
        <th>Acciones</th>
    </tr>

    <?php foreach($libros as $libro): ?>
    <tr class="border-b text-center">
        <td><?= $libro['id'] ?></td>
        <td><?= $libro['titulo'] ?></td>
        <td>$<?= $libro['precio'] ?></td>
        <td><?= $libro['categoria'] ?></td>
        <td>
            <a href="editar_libro.php?id=<?= $libro['id'] ?>" 
               class="bg-blue-500 text-white px-3 py-1 rounded">
                Editar
            </a>

            <a href="eliminar_libro.php?id=<?= $libro['id'] ?>" 
               class="bg-red-500 text-white px-3 py-1 rounded"
               onclick="return confirm('¿Seguro que quieres eliminar este libro?')">
                Eliminar
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<div class="mt-10">
    <a href="../index.php" class="text-blue-600 underline">Volver al Inicio</a>
</div>

</body>
</html>