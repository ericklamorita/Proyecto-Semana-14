<?php
session_start();
// 1. La conexión está en la carpeta 'conexion/', entramos directo
require('conexion/conexion.php');

// 2. SEGURIDAD: Si el trabajador no ha iniciado sesión, lo mandamos al login en 'auth/'
if (!isset($_SESSION['usuario_id'])) {
    header("Location: auth/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id']; 

// Consulta para obtener el historial del trabajador actual
$sql = "SELECT fecha, hora_entrada, hora_salida 
        FROM asistencias 
        WHERE trabajador_id = ? 
        ORDER BY fecha DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario_id]);
$registros = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mi Historial | Villa de Libros</title>
        <style>
            :root {
                --primary-color: #00d4ff;
                --bg-dark: #0f172a;
                --card-bg: rgba(30, 41, 59, 0.7);
            }

            body {
                font-family: 'Segoe UI', sans-serif;
                background-color: var(--bg-dark);
                color: white;
                margin: 0;
                padding: 40px 20px;
                display: flex;
                justify-content: center;
            }

            .container {
                max-width: 900px;
                width: 100%;
                background: var(--card-bg);
                padding: 40px;
                border-radius: 20px;
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(12px);
            }

            h2 {
                color: white;
                margin-top: 0;
                border-bottom: 2px solid var(--primary-color);
                padding-bottom: 10px;
                font-weight: 600;
            }

            .emp-info {
                color: #94a3b8;
                margin-bottom: 30px;
            }

            .emp-info strong {
                color: var(--primary-color);
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                background: rgba(255, 255, 255, 0.03);
                border-radius: 12px;
                overflow: hidden;
            }

            th, td {
                padding: 15px;
                text-align: left;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }

            th {
                background-color: rgba(0, 212, 255, 0.1);
                color: var(--primary-color);
                text-transform: uppercase;
                font-size: 0.85rem;
                letter-spacing: 1px;
            }

            tr:hover {
                background-color: rgba(255, 255, 255, 0.05);
            }

            .btn-back {
                display: inline-block;
                margin-bottom: 20px;
                text-decoration: none;
                color: var(--primary-color);
                font-weight: 600;
                transition: 0.3s;
            }

            .btn-back:hover {
                transform: translateX(-5px);
                color: white;
            }

            .status-complete {
                color: #4ade80;
                background: rgba(74, 222, 128, 0.1);
                padding: 4px 10px;
                border-radius: 6px;
                font-size: 0.85rem;
            }

            .status-pending {
                color: #fbbf24;
                background: rgba(251, 191, 36, 0.1);
                padding: 4px 10px;
                border-radius: 6px;
                font-size: 0.85rem;
            }

            .no-data {
                text-align: center;
                padding: 40px;
                color: #94a3b8;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <a href="index.php" class="btn-back">← Volver al Panel de Control</a>

            <h2>Historial de Asistencia Personal</h2>
            <p class="emp-info">Colaborador: <strong><?= htmlspecialchars($_SESSION['nombre'] ?? 'Usuario') ?></strong></p>

            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Estado de Jornada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($registros) > 0): ?>
                        <?php foreach ($registros as $fila): ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($fila['fecha'])) ?></td>
                                <td style="font-family: monospace;"><?= $fila['hora_entrada'] ?></td>
                                <td style="font-family: monospace;"><?= $fila['hora_salida'] ?? '--:--:--' ?></td>
                                <td>
                                    <?php if ($fila['hora_salida']): ?>
                                        <span class="status-complete">● Completado</span>
                                    <?php else: ?>
                                        <span class="status-pending">○ En curso</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="no-data">No se han encontrado registros de asistencia en tu historial.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </body>
</html>