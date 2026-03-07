<?php
session_start();
require('conexion/conexion.php');

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

<input type="text" name="titulo" value="<?= $libro['titulo'] ?>" class="w-full border p-2 mb-3">

<textarea name="descripcion" class="w-full border p-2 mb-3"><?= $libro['descripcion'] ?></textarea>

<input type="number" step="0.01" name="precio" value="<?= $libro['precio'] ?>" class="w-full border p-2 mb-3">

<input type="text" name="imagen" value="<?= $libro['imagen'] ?>" class="w-full border p-2 mb-3">

<select name="categoria_id" class="w-full border p-2 mb-3">

<?php foreach($categorias as $categoria): ?>

<option value="<?= $categoria['id'] ?>"
<?php if($categoria['id']==$libro['categoria_id']) echo "selected"; ?>>

<?= $categoria['nombre'] ?>

</option>

<?php endforeach; ?>

</select>

<button class="bg-blue-600 text-white px-4 py-2 rounded w-full">
Actualizar Libro
</button>

</form>

</div>

</body>
</html>