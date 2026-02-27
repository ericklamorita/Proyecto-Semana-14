<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro de Personal | Librería Puriscaleña</title>

        <style>
            :root {
                --primary-color: #00d4ff;
                --bg-overlay: rgba(15, 23, 42, 0.9);
            }

            body, html {
                height: 100vh; /* Usar vh es más seguro para pantallas móviles */
                margin: 0;
                font-family: 'Segoe UI', sans-serif;
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #0f172a;
            }

            /* Imagen de fondo sutil */
            .bg-blur {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-image: url('');
                background-size: cover;
                background-position: center;
                filter: brightness(0.3) blur(8px);
                z-index: -1;
            }

            .reg-container {
                background: var(--bg-overlay);
                padding: 40px;
                border-radius: 16px;
                border: 1px solid rgba(255, 255, 255, 0.1);
                width: 380px;
                /* Esto es lo que evita que se estire */
                max-height: 90vh;
                overflow-y: auto; /* Por si la pantalla es muy pequeña */
                text-align: center;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(10px);
                z-index: 1; /* Para que esté por encima del fondo */
            }

            h2 {
                font-weight: 600;
                letter-spacing: 1px;
                margin-bottom: 8px;
                color: white;
            }

            .subtitle {
                color: #94a3b8;
                font-size: 0.9rem;
                margin-bottom: 30px;
                display: block;
            }

            input {
                width: 100%;
                padding: 12px 15px;
                margin: 10px 0;
                background: rgba(255, 255, 255, 0.05);
                border: 1px solid rgba(255, 255, 255, 0.2);
                color: white;
                border-radius: 8px;
                outline: none;
                transition: 0.3s;
                box-sizing: border-box;
            }

            input:focus {
                border-color: var(--primary-color);
                background: rgba(255, 255, 255, 0.1);
                box-shadow: 0 0 0 4px rgba(0, 212, 255, 0.15);
            }

            button {
                width: 100%;
                padding: 14px;
                margin-top: 20px;
                background-color: var(--primary-color);
                color: #0f172a;
                border: none;
                border-radius: 8px;
                font-weight: bold;
                text-transform: uppercase;
                cursor: pointer;
                transition: 0.3s;
            }

            button:hover {
                background-color: white;
                transform: translateY(-2px);
            }

            .back-link {
                margin-top: 25px;
                font-size: 0.85rem;
                color: #94a3b8;
            }

            .back-link a {
                color: var(--primary-color);
                text-decoration: none;
                font-weight: 600;
            }
        </style>
    </head>
    <body>

        <div class="bg-blur"></div>

        <div class="reg-container">
            <h2>Crear Cuenta</h2>
            <span class="subtitle">Formulario de registro</span>

            <input type="text" id="nombre" placeholder="Nombre completo">
            <input type="email" id="email" placeholder="Correo institucional">
            <input type="password" id="password" placeholder="Contraseña de acceso">

            <button id="btnRegistrar">Completar Registro</button>

            <div class="back-link">
                ¿Ya tiene una cuenta? <a href="login.php">Iniciar sesión</a>
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