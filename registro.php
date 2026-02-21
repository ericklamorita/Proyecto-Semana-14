<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Registrarse en el Olimpo</title>
        <link rel="stylesheet" href="css/style.css">
        <style>
            /* Reutiliza el estilo de tu login para que se vea igual de épico */
            body {
                background-color: #0b0d17;
                color: white;
                font-family: sans-serif;
                text-align: center;
                padding-top: 50px;
            }
            .reg-container {
                background: rgba(0,0,0,0.8);
                padding: 30px;
                border-radius: 10px;
                border: 1px solid #00d4ff;
                display: inline-block;
            }
            input {
                display: block;
                width: 250px;
                padding: 10px;
                margin: 10px auto;
                background: #1a1a1a;
                border: 1px solid #00d4ff;
                color: white;
            }
            button {
                background: #00d4ff;
                color: black;
                border: none;
                padding: 10px 20px;
                cursor: pointer;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="reg-container">
            <h2>Únete a las Legiones</h2>
            <input type="text" id="nombre" placeholder="Nombre de Guerrero">
            <input type="email" id="email" placeholder="Correo electrónico">
            <input type="password" id="password" placeholder="Contraseña">
            <button id="btnRegistrar">CONSAGRAR REGISTRO</button>
            <p><a href="login.php" style="color: #00d4ff; text-decoration: none; font-size: 0.8em;">YA SOY DIGNO (VOLVER)</a></p>
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
                    alert("¡Mortal! No dejes campos vacíos.");
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
                                alert("¡Has sido aceptado en el Olimpo!");
                                window.location.href = 'login.php';
                            }
                        })
                        .catch((error) => alert("Error del Olimpo: " + error.message));
            });
        </script>
    </body>
</html>