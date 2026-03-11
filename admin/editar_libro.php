<?php
session_start();
// 1. Ajuste de ruta para la conexión: salimos de 'admin' para entrar a 'conexion'
require('../conexion/conexion.php');

// Verificación de seguridad (opcional pero recomendada si ya está en los otros archivos)
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../seleccion.php");
    exit();
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM producto WHERE id=?");
$stmt->execute([$id]);
$libro = $stmt->fetch();

$categorias = $pdo->query("SELECT * FROM categorias")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Libro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 flex justify-center items-center min-h-screen">

<div class="bg-white p-8 rounded-xl shadow-xl w-[400px]">

    <h2 class="text-2xl font-bold mb-6">Editar Libro</h2>

    <form action="actualizar_libro.php" method="POST">

        <input type="hidden" name="id" value="<?= $libro['id'] ?>">

        <label class="text-xs text-gray-500">Título</label>
        <input type="text" name="titulo" value="<?= $libro['titulo'] ?>" class="w-full border p-2 mb-3">

        <label class="text-xs text-gray-500">Descripción</label>
        <textarea name="descripcion" class="w-full border p-2 mb-3"><?= $libro['descripcion'] ?></textarea>

        <label class="text-xs text-gray-500">Precio</label>
        <input type="number" step="0.01" name="precio" value="<?= $libro['precio'] ?>" class="w-full border p-2 mb-3">

        <label class="text-xs text-gray-500">URL Imagen</label>
        <input type="text" name="imagen" value="<?= $libro['imagen'] ?>" class="w-full border p-2 mb-3">

        <label class="text-xs text-gray-500">Categoría</label>
        <select name="categoria_id" class="w-full border p-2 mb-3">
            <?php foreach($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>"
                    <?php if($categoria['id'] == $libro['categoria_id']) echo "selected"; ?>>
                    <?= $categoria['nombre'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded w-full">
            Actualizar Libro
        </button>

        <div class="mt-4 text-center">
            <a href="admin_libros.php" class="text-sm text-blue-500 hover:underline">Regresar al panel</a>
        </div>

    </form>

</div>

</body>
</html>