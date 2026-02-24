<?php
session_start();
require_once 'conexion/conexion.php';

$carrito = $_SESSION['carrito'] ?? [];
$gran_total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Carrito | Villa de Libros</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">
    <div class="container mx-auto p-10">
        <h1 class="text-3xl font-bold mb-6 text-slate-800">🛒 Tu Carrito de Alquiler</h1>
        
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <?php if (empty($carrito)): ?>
                <p class="text-center text-slate-500 py-10">El carrito está vacío. <a href="catalogo.php" class="text-cyan-600 font-bold">Ir al catálogo</a></p>
            <?php else: ?>
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-4">Libro</th>
                            <th>Periodo</th>
                            <th>Total (IVA incl.)</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carrito as $indice => $item): 
                            $gran_total += $item['total']; ?>
                        <tr class="border-b">
                            <td class="py-4 font-bold"><?php echo $item['titulo']; ?></td>
                            <td class="text-sm text-slate-600">
                                Del <?php echo $item['inicio']; ?> al <?php echo $item['fin']; ?>
                            </td>
                            <td class="font-bold text-cyan-600">$<?php echo $item['total']; ?></td>
                            <td>
                                <a href="eliminar_item.php?id=<?php echo $indice; ?>" class="text-red-500 hover:underline">Quitar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="mt-8 flex justify-between items-center">
                    <span class="text-2xl font-extrabold text-slate-900">Total Final: $<?php echo number_format($gran_total, 2); ?></span>
                    <div class="space-x-4">
                        <a href="catalogo.php" class="bg-slate-200 px-6 py-3 rounded-lg font-bold">Seguir Comprando</a>
                        <a href="finalizar_alquiler.php" class="bg-green-500 text-white px-8 py-3 rounded-lg font-bold shadow-lg hover:bg-green-600">Finalizar Alquiler</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>