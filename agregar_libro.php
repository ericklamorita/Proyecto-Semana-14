<?php
session_start();
require('conexion/conexion.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: seleccion.php");
    exit();
}

$categorias = $pdo->query("SELECT * FROM categorias")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Agregar Libro</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 flex justify-center items-center min-h-screen">

<div class="bg-white p-8 rounded-xl shadow-xl w-[400px]">

<h2 class="text-2xl font-bold mb-6">Agregar nuevo libro</h2>

<form action="guardar_libro.php" method="POST">

<input type="text" name="titulo" placeholder="Título" class="w-full border p-2 mb-3" required>

<textarea name="descripcion" placeholder="Descripción" class="w-full border p-2 mb-3"></textarea>

<input type="number" step="0.01" name="precio" placeholder="Precio por día" class="w-full border p-2 mb-3" required>

<input type="text" name="imagen" placeholder="URL de imagen o image/libro.jpg" class="w-full border p-2 mb-3">

<select name="categoria_id" class="w-full border p-2 mb-3">

<?php foreach($categorias as $categoria): ?>

<option value="<?= $categoria['id'] ?>">
<?= $categoria['nombre'] ?>
</option>

<?php endforeach; ?>

</select>

<button class="bg-slate-900 text-white px-4 py-2 rounded w-full">
Guardar Libro
</button>

</form>

</div>

</body>
</html>