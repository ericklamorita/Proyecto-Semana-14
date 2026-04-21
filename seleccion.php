<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido | Villa de Libros</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), 
                        url('https://thumbs.dreamstime.com/z/una-extra%C3%B1a-aldea-de-libros-cuentos-cobra-vida-en-un-libro-abierto-esta-encantadora-ilustraci%C3%B3n-muestra-caprichosa-casas-395741030.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
    </style>
</head>
<body class="flex items-center justify-center">
    <div class="bg-slate-900/90 p-10 rounded-2xl border border-slate-700 shadow-2xl text-center max-w-lg backdrop-blur-sm">
        <h1 class="text-3xl font-bold text-white mb-2">Villa de Libros</h1>
        <p class="text-slate-400 mb-8">Seleccione su perfil para continuar</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="auth/login.php?rol=trabajador" class="group p-6 bg-slate-800 rounded-xl border border-slate-600 hover:border-cyan-400 transition-all">
                <div class="text-4xl mb-3">👔</div>
                <h3 class="text-xl font-bold text-white group-hover:text-cyan-400">Trabajador</h3>
                <p class="text-xs text-slate-500 mt-2">Marcas de asistencia y gestión</p>
            </a>

            <a href="auth/login.php?rol=cliente" class="group p-6 bg-slate-800 rounded-xl border border-slate-600 hover:border-green-400 transition-all">
                <div class="text-4xl mb-3">📖</div>
                <h3 class="text-xl font-bold text-white group-hover:text-green-400">Cliente</h3>
                <p class="text-xs text-slate-500 mt-2">Consulta y alquiler de libros</p>
            </a>
        </div>
    </div>
</body>
</html>