<?php
session_start();
// 1. La conexión está en su carpeta, entramos directamente
require_once 'conexion/conexion.php';

// Obtener categorías
$conteo_carrito = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;
$stmtCategorias = $pdo->query("SELECT * FROM categorias");
$categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);

// Obtener datos del formulario
$titulo = $_POST['titulo'] ?? '';
$genero = $_POST['genero'] ?? '';

// Consulta base
$sql = "SELECT p.*, c.nombre AS categoria
        FROM producto p
        LEFT JOIN categorias c ON p.categoria_id = c.id
        WHERE 1=1";

$params = [];

// Filtro por título
if (!empty($titulo)) {
    $sql .= " AND p.titulo LIKE ?";
    $params[] = "%$titulo%";
}

// Filtro por género
if (!empty($genero)) {
    $sql .= " AND c.id = ?";
    $params[] = $genero;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Buscador de Libros</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-white p-10">
        <nav class="bg-slate-900 p-4 text-white shadow-xl sticky top-0 z-50">
            <div class="container mx-auto flex justify-between items-center">
                <h1 class="text-xl font-bold tracking-wider text-cyan-400">
                    <a href="catalogo.php" class="hover:text-cyan-400 transition flex items-center gap-2">
                        <span>Villa De Libros</span>
                    </a>
                </h1>
                <div class="flex items-center space-x-6">
                    <a href="alquiler/mis_alquileres.php" class="hover:text-cyan-400 transition flex items-center gap-2">
                        📖 <span>Mi Historial</span>
                    </a>

                    <a href="alquiler/carrito.php" class="relative hover:text-cyan-400 transition flex items-center gap-2">
                        🛒 <span>Carrito</span>
                        <?php if ($conteo_carrito > 0): ?>
                            <span class="absolute -top-2 -right-3 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                <?php echo $conteo_carrito; ?>
                            </span>
                        <?php endif; ?>
                    </a>

                    <div class="h-6 w-px bg-slate-700"></div>

                    <div class="flex items-center gap-4">
                        <span class="text-sm text-slate-300 italic">Hola, <?php echo $_SESSION['nombre']; ?></span>
                        <a href="auth/logout.php" class="bg-red-500/10 text-red-400 px-3 py-1 rounded-lg border border-red-500/20 hover:bg-red-500 hover:text-white transition text-sm">
                            Salir
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <h1 class="text-3xl font-bold mb-6 mt-6">Buscar Libros</h1>

        <form method="POST" class="bg-white p-6 rounded-xl shadow-md mb-8 flex gap-4">
            <input type="text" name="titulo" placeholder="Buscar por título" value="<?php echo htmlspecialchars($titulo); ?>" class="border p-2 rounded w-1/2">
            <select name="genero" class="border p-2 rounded w-1/3">
                <option value="">Todos los géneros</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php if ($genero == $cat['id']) echo 'selected'; ?>>
                        <?php echo $cat['nombre']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-6 rounded">BUSCAR</button>
        </form>

<table class="w-full bg-white shadow-xl rounded-2xl overflow-hidden border border-slate-200">
    
    <thead class="bg-slate-900 text-white">
        <tr>
            <th class="p-4 text-left">Libro</th>
            <th class="p-4 text-left">Categoría</th>
            <th class="p-4 text-left">Precio</th>
            <th class="p-4 text-center">Acción</th>
        </tr>
    </thead>

    <tbody>
        <?php if (count($libros) > 0): ?>
            <?php foreach ($libros as $libro): ?>
                <tr class="border-b hover:bg-slate-50 transition duration-200">
                    
                    <!-- LIBRO -->
                    <td class="p-4">
                        <p class="font-bold text-slate-800">
                            <?php echo $libro['titulo']; ?>
                        </p>
                        <p class="text-sm text-slate-500 line-clamp-1">
                            <?php echo $libro['descripcion']; ?>
                        </p>
                    </td>

                    <!-- CATEGORÍA -->
                    <td class="p-4">
                        <span class="bg-cyan-100 text-cyan-700 px-3 py-1 rounded-full text-xs font-semibold">
                            <?php echo $libro['categoria']; ?>
                        </span>
                    </td>

                    <!-- PRECIO -->
                    <td class="p-4">
                        <span class="text-lg font-black text-slate-900">
                            $<?php echo number_format($libro['precio'], 2); ?>
                        </span>
                    </td>

                    <!-- ACCIÓN -->
                    <td class="p-4 text-center">
                        <a href="detalles.php?id=<?php echo $libro['id']; ?>" 
                           class="bg-slate-900 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-cyan-600 transition shadow">
                            Ver Detalles
                        </a>
                    </td>

                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4" class="text-center p-10 text-gray-400">
                    <span class="text-4xl">🔎</span><br>
                    NO HAY RESULTADOS
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

    </body>
</html>