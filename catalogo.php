<?php
session_start();
require_once 'conexion/conexion.php';

// SEGURIDAD: Si no es cliente, lo mandamos afuera
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: seleccion.php");
    exit();
}

// Contar cuántos libros hay en el carrito actualmente
$conteo_carrito = isset($_SESSION['carrito']) ? count($_SESSION['carrito']) : 0;

// CONSULTA DE LIBROS
$stmt = $pdo->query("SELECT p.*, c.nombre as categoria 
                     FROM producto p 
                     LEFT JOIN categorias c ON p.categoria_id = c.id");
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo | Villa de libros</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">
    <nav class="bg-slate-900 p-4 text-white shadow-xl sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-wider text-cyan-400">VILLA DE LIBROS</h1>
            
            <div class="flex items-center space-x-6">
                <a href="mis_alquileres.php" class="hover:text-cyan-400 transition flex items-center gap-2">
                    📖 <span>Mi Historial</span>
                </a>

                <a href="carrito.php" class="relative hover:text-cyan-400 transition flex items-center gap-2">
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
                    <a href="logout.php" class="bg-red-500/10 text-red-400 px-3 py-1 rounded-lg border border-red-500/20 hover:bg-red-500 hover:text-white transition text-sm">
                        Salir
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-8">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-4xl font-extrabold text-slate-800">Descubre tu próxima aventura</h2>
                <p class="text-slate-500 mt-2">Explora nuestra colección exclusiva de Villa de Libros</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($libros as $libro): ?>
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden border border-slate-200 group">
                <div class="relative overflow-hidden">
                    <img src="<?php echo $libro['imagen']; ?>" class="h-56 w-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-cyan-600 shadow-sm">
                        <?php echo $libro['categoria']; ?>
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-slate-800"><?php echo $libro['titulo']; ?></h3>
                    <p class="text-slate-600 text-sm mt-3 line-clamp-2 leading-relaxed"><?php echo $libro['descripcion']; ?></p>
                    
                    <div class="flex justify-between items-center mt-6 pt-4 border-t border-slate-50">
                        <div>
                            <span class="text-xs text-slate-400 block uppercase">Precio/Día</span>
                            <span class="text-2xl font-black text-slate-900">$<?php echo number_format($libro['precio'], 2); ?></span>
                        </div>
                        <a href="detalles.php?id=<?php echo $libro['id']; ?>" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-cyan-600 transition-colors shadow-lg shadow-slate-200">
                            Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>