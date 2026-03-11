<?php
session_start();
// 1. La conexión está en su carpeta, entramos directo
require_once 'conexion/conexion.php';

// SEGURIDAD: Solo clientes
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'cliente') {
    header("Location: seleccion.php");
    exit();
}

$id = $_GET['id'] ?? 0;

$stmt = $pdo->prepare("SELECT p.*, c.nombre as categoria FROM producto p 
                       LEFT JOIN categorias c ON p.categoria_id = c.id 
                       WHERE p.id = ?");
$stmt->execute([$id]);
$libro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$libro) {
    die("Libro no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alquilar: <?php echo $libro['titulo']; ?> | Villa de Libros</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50">

    <div class="container mx-auto p-10">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
            
            <div class="md:w-1/2 bg-slate-200">
                <img src="<?php echo $libro['imagen']; ?>" class="w-full h-full object-cover">
            </div>

            <div class="md:w-1/2 p-8">
                <div class="flex justify-between items-start">
                    <a href="catalogo.php" class="text-cyan-600 text-sm font-bold">← Volver al catálogo</a>
                    <span class="bg-cyan-100 text-cyan-700 text-xs px-2 py-1 rounded font-bold"><?php echo $libro['categoria']; ?></span>
                </div>
                
                <h1 class="text-3xl font-bold mt-4"><?php echo $libro['titulo']; ?></h1>
                <p class="text-slate-500 mt-2"><?php echo $libro['descripcion']; ?></p>
                
                <hr class="my-6">

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Fecha Inicio</label>
                        <input type="date" id="fecha_inicio" min="<?php echo date('Y-m-d'); ?>" 
                               class="w-full mt-1 p-2 border rounded-md border-slate-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700">Fecha Fin</label>
                        <input type="date" id="fecha_fin" min="<?php echo date('Y-m-d'); ?>" 
                               class="w-full mt-1 p-2 border rounded-md border-slate-300 shadow-sm focus:ring-cyan-500 focus:border-cyan-500">
                    </div>
                </div>

                <div class="bg-slate-100 p-4 rounded-xl space-y-2 mb-6">
                    <div class="flex justify-between">
                        <span>Precio por día:</span>
                        <span class="font-bold">$<span id="precio_base"><?php echo $libro['precio']; ?></span></span>
                    </div>
                    <div class="flex justify-between">
                        <span>Días totales:</span>
                        <span id="display_dias" class="font-bold">0</span>
                    </div>
                    <div class="flex justify-between text-slate-600 border-t pt-2">
                        <span>Subtotal:</span>
                        <span>$ <span id="display_subtotal">0.00</span></span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>IVA (13%):</span>
                        <span>$ <span id="display_iva">0.00</span></span>
                    </div>
                    <div class="flex justify-between text-xl font-extrabold text-slate-900 border-t-2 border-slate-300 pt-2">
                        <span>Total:</span>
                        <span>$ <span id="display_total">0.00</span></span>
                    </div>
                </div>

                <form action="alquiler/agregar_carrito.php" method="POST" id="formAlquiler">
                    <input type="hidden" name="producto_id" value="<?php echo $libro['id']; ?>">
                    <input type="hidden" name="titulo" value="<?php echo $libro['titulo']; ?>">
                    <input type="hidden" name="precio" value="<?php echo $libro['precio']; ?>">
                    
                    <input type="hidden" name="fecha_inicio" id="hidden_inicio">
                    <input type="hidden" name="fecha_fin" id="hidden_fin">
                    <input type="hidden" name="total_pago" id="hidden_total">

                    <button type="submit" class="w-full bg-cyan-500 text-white py-4 rounded-xl font-bold hover:bg-cyan-600 shadow-lg transition-all transform hover:-translate-y-1">
                        🛒 Añadir al Carrito
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const inputInicio = document.getElementById('fecha_inicio');
        const inputFin = document.getElementById('fecha_fin');
        const precioDia = parseFloat(document.getElementById('precio_base').innerText);
        const MAX_DIAS = 30;

        function calcular() {
            if (inputInicio.value && inputFin.value) {
                const fecha1 = new Date(inputInicio.value);
                const fecha2 = new Date(inputFin.value);

                if (fecha2 <= fecha1) {
                    alert("La fecha de fin debe ser posterior a la de inicio");
                    inputFin.value = "";
                    resetearTotales();
                    return;
                }

                const diferencia = fecha2 - fecha1;
                const dias = Math.ceil(diferencia / (1000 * 60 * 60 * 24));

                if (dias > MAX_DIAS) {
                    alert("Regla de Villa de Libros: Máximo " + MAX_DIAS + " días por alquiler.");
                    inputFin.value = "";
                    resetearTotales();
                    return;
                }

                const subtotal = dias * precioDia;
                const iva = subtotal * 0.13;
                const total = subtotal + iva;

                document.getElementById('display_dias').innerText = dias;
                document.getElementById('display_subtotal').innerText = subtotal.toFixed(2);
                document.getElementById('display_iva').innerText = iva.toFixed(2);
                document.getElementById('display_total').innerText = total.toFixed(2);

                document.getElementById('hidden_inicio').value = inputInicio.value;
                document.getElementById('hidden_fin').value = inputFin.value;
                document.getElementById('hidden_total').value = total.toFixed(2);
            }
        }

        function resetearTotales() {
            document.getElementById('display_dias').innerText = "0";
            document.getElementById('display_subtotal').innerText = "0.00";
            document.getElementById('display_iva').innerText = "0.00";
            document.getElementById('display_total').innerText = "0.00";
            document.getElementById('hidden_total').value = "";
        }

        inputInicio.addEventListener('change', () => {
            inputFin.min = inputInicio.value;
            calcular();
        });
        inputFin.addEventListener('change', calcular);
    </script>
</body>
</html>