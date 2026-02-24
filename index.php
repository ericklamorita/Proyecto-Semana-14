<?php
session_start();
require('conexion/conexion.php');

// Verificación de sesión [cite: 34]
if (!isset($_SESSION['usuario_id'])) {
    header("Location: seleccion.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$fecha_hoy = date('Y-m-d');

// Consultamos el estado de asistencia del día actual [cite: 41]
$sql = "SELECT * FROM asistencias WHERE trabajador_id = ? AND fecha = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario_id, $fecha_hoy]);
$asistencia = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Asistencia | Librería Puriscaleña</title>
    <style>
        :root {
            --primary-color: #00d4ff;
            --bg-dark: #0f172a; /* Azul medianoche corporativo */
            --card-bg: rgba(30, 41, 59, 0.7); /* Azul pizarra con transparencia */
        }

        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-dark);
            color: white;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .dashboard {
            max-width: 500px;
            width: 90%;
            background: var(--card-bg);
            padding: 40px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(12px);
            text-align: center;
        }

        h2 {
            margin-top: 0;
            font-weight: 600;
            letter-spacing: 1px;
        }

        #reloj {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 10px 0;
            text-shadow: 0 0 20px rgba(0, 212, 255, 0.3);
        }

        .fecha-actual {
            color: #94a3b8;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        /* Estilo de la Status Card para Modo Oscuro [cite: 42] */
        .status-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 25px;
            border-radius: 12px;
            border: 1px dashed rgba(255, 255, 255, 0.2);
            margin-bottom: 30px;
        }

        .btn {
            display: block;
            padding: 15px;
            color: #0f172a;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            margin: 10px 0;
        }

        .btn-in { background-color: #22c55e; }
        .btn-in:hover { 
            background-color: #4ade80; 
            box-shadow: 0 0 20px rgba(34, 197, 94, 0.4);
            transform: translateY(-2px);
        }

        .btn-out { background-color: #f97316; }
        .btn-out:hover { 
            background-color: #fb923c; 
            box-shadow: 0 0 20px rgba(249, 115, 22, 0.4);
            transform: translateY(-2px);
        }

        .links-container {
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
        }

        .link-historial {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .link-historial:hover { text-decoration: underline; }

        .link-logout {
            display: block;
            margin-top: 15px;
            color: #ef4444;
            text-decoration: none;
            font-size: 0.9rem;
            opacity: 0.8;
        }
        
        .link-logout:hover { opacity: 1; }
    </style>

    <script>
        function actualizarReloj() {
            const ahora = new Date();
            document.getElementById('reloj').innerText = ahora.toLocaleTimeString();
        }
        setInterval(actualizarReloj, 1000);
    </script>
</head>
<body onload="actualizarReloj()">

    <div class="dashboard">
        <h2>Hola, <?= htmlspecialchars($_SESSION['nombre']) ?></h2>
        <div id="reloj">--:--:--</div>
        <p class="fecha-actual"><?= date('d/m/Y') ?></p>

        <div class="status-card">
            <?php if (!$asistencia): ?>
                <p style="color: #fbbf24;"><strong>Estado:</strong> Pendiente de ingreso</p>
                <a href="registrar_asistencia.php?accion=entrada" class="btn btn-in">Marcar Entrada</a>
            <?php elseif ($asistencia['hora_salida'] == NULL): ?>
                <p style="color: #4ade80;"><strong>Entrada:</strong> <?= $asistencia['hora_entrada'] ?></p>
                <p style="font-size: 0.9rem; color: #94a3b8;">Jornada en curso</p>
                <a href="registrar_asistencia.php?accion=salida" class="btn btn-out">Marcar Salida</a>
            <?php else: ?>
                <p style="color: var(--primary-color);"><strong>Jornada Finalizada</strong></p>
                <p style="font-size: 0.9rem;">Entrada: <?= $asistencia['hora_entrada'] ?> | Salida: <?= $asistencia['hora_salida'] ?></p>
            <?php endif; ?>
        </div>

        <div class="links-container">
            <a href="historial_marcas.php" class="link-historial">Consultar mi historial</a>
            <a href="logout.php" class="link-logout">Cerrar sesión del sistema</a>
        </div>
    </div>

</body>
</html>