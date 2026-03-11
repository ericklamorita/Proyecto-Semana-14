<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | Villa de Libros</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-login"> <div class="overlay"></div> <div class="glass-container" style="max-width: 450px; margin: 8vh auto;">
        <h2 style="color: var(--primary-color); margin-bottom: 5px;">Crear Cuenta</h2>
        <p class="subtitle" style="color: var(--text-muted); margin-bottom: 30px;">Formulario de registro</p>

        <div class="input-group">
            <input type="text" id="nombre" placeholder="Nombre completo">
        </div>
        <div class="input-group">
            <input type="email" id="email" placeholder="Correo institucional">
        </div>
        <div class="input-group">
            <input type="password" id="password" placeholder="Contraseña de acceso">
        </div>

        <button id="btnRegistrar" class="btn btn-in">Completar Registro</button>

        <div class="back-link" style="margin-top: 25px; color: var(--text-muted); font-size: 0.9rem;">
            ¿Ya tiene una cuenta? 
            <a href="login.php" style="color: var(--primary-color); text-decoration: none; font-weight: bold;">Iniciar sesión</a>
        </div>
        
        <div style="margin-top: 15px;">
            <a href="../seleccion.php" style="color: var(--text-muted); text-decoration: none; font-size: 0.8rem;">← Volver a selección</a>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/12.9.0/firebase-app.js";
        import { getAuth, createUserWithEmailAndPassword }
        from "https://www.gstatic.com/firebasejs/12.9.0/firebase-auth.js";

        const firebaseConfig = {
            apiKey: "AIzaSyALbqs9AXyp8KXrbsnCFL3Gwg1RBNXvdQ0",
            authDomain: "proyectosemana14-17172.firebaseapp.com",
            projectId: "proyectosemana14-17172",
            storageBucket: "proyectosemana14-17172.firebasestorage.app",
            messagingSenderId: "236574906112",
            appId: "1:236574906112:web:6ee3482315b268a1a645e5",
            measurementId: "G-TK5Z79CD1R"
        };

        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);

        document.getElementById('btnRegistrar').addEventListener('click', () => {
            const email = document.getElementById('email').value;
            const pass = document.getElementById('password').value;
            const nombre = document.getElementById('nombre').value;

            if (!email || !pass || !nombre) {
                alert("Por favor, complete todos los campos obligatorios.");
                return;
            }

            createUserWithEmailAndPassword(auth, email, pass)
                .then((userCredential) => {
                    const formData = new FormData();
                    formData.append('nombre', nombre);
                    formData.append('email', email);
                    formData.append('uid', userCredential.user.uid);

                    return fetch('procesar_registro.php', {method: 'POST', body: formData});
                })
                .then(response => {
                    if (response.ok) {
                        alert("Cuenta creada exitosamente. Ya puede iniciar sesión.");
                        window.location.href = 'login.php';
                    }
                })
                .catch((error) => alert("Error en el registro: " + error.message));
        });
    </script>
</body>
</html>