<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema | Villa de Libros</title>

    <style>
        :root {
            --primary-color: #00d4ff;
            --bg-overlay: rgba(15, 23, 42, 0.85);
            --glass-bg: rgba(255, 255, 255, 0.1);
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: white;
            overflow: hidden;
        }

        .bg-image {
            background-image: url('https://png.pngtree.com/background/20230527/original/pngtree-an-old-bookcase-in-a-library-picture-image_2760144.jpg');
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: absolute;
            width: 100%;
            z-index: -1;
            transform: scale(1.1);
        }

        .overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9), rgba(0, 212, 255, 0.2));
            z-index: 0;
        }

        .login-container {
            background: var(--bg-overlay);
            padding: 50px 40px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            width: 350px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            backdrop-filter: blur(12px);
            z-index: 1;
        }

        h2 {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            color: white;
            font-size: 1.5rem;
        }

        .subtitle {
            color: #94a3b8;
            margin-bottom: 30px;
            display: block;
            font-size: 0.85rem;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            margin-top: 5px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 8px;
            outline: none;
            transition: all 0.3s;
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
            letter-spacing: 1px;
        }

        button:hover {
            background-color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 212, 255, 0.4);
        }

        #btnGoogle {
            background: transparent;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 15px;
        }

        #btnGoogle:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
        }

        .separator {
            margin: 25px 0;
            display: flex;
            align-items: center;
            color: #64748b;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .separator::before, .separator::after {
            content: "";
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0 10px;
        }

        .footer-link {
            font-size: 0.85rem;
            color: #94a3b8;
            margin-top: 20px;
        }

        .footer-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="bg-image"></div>
    <div class="overlay"></div>

    <div class="login-container">
        <h2 id="login-title">Bienvenido</h2>
        <span class="subtitle">Ingrese sus credenciales</span>

        <div class="input-group">
            <input type="email" id="email" placeholder="Correo electrónico">
        </div>
        <div class="input-group">
            <input type="password" id="pass" placeholder="Contraseña">
        </div>

        <button id="btnLogin">Iniciar Sesión</button>

        <div class="separator">o continuar con</div>

        <button id="btnGoogle">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/500px-Google_%22G%22_logo.svg.png" alt="G" style="width: 18px;">
            ACCEDER CON GOOGLE
        </button>

        <div id="seccion-registro">
            <div class="separator">o si eres nuevo</div>
            <div class="footer-link">
                <p style="margin-bottom: 10px;">¿Aún no vives en la Villa?</p>
                <a href="registro.php" style="display: block; background: rgba(0, 212, 255, 0.1); padding: 10px; border-radius: 8px; border: 1px solid var(--primary-color); margin-bottom: 20px;">
                    CREAR CUENTA NUEVA
                </a>
            </div>
        </div>

        <div class="footer-link">
            <a href="seleccion.php">← Volver a selección</a>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/12.9.0/firebase-app.js";
        import { getAuth, signInWithEmailAndPassword, GoogleAuthProvider, signInWithPopup }
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
        const provider = new GoogleAuthProvider();

        const urlParams = new URLSearchParams(window.location.search);
        const rolElegido = urlParams.get('rol') || 'cliente';

        // Título dinámico
        document.getElementById('login-title').innerText = "Acceso " + (rolElegido === 'trabajador' ? "Personal" : "Clientes");

        // OCULTAR REGISTRO SI ES TRABAJADOR
        if (rolElegido === 'trabajador') {
            document.getElementById('seccion-registro').style.display = 'none';
        }

        const loginExitoso = (user) => {
            const formData = new FormData();
            formData.append('uid', user.uid);
            formData.append('email', user.email);
            formData.append('rol', rolElegido);

            fetch('autenticar.php', {method: 'POST', body: formData})
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = (rolElegido === 'trabajador') ? 'index.php' : 'catalogo.php';
                    } else {
                        alert("Acceso denegado: No se encontró registro para este perfil.");
                    }
                })
                .catch(error => alert("Error en el servidor."));
        };

        document.getElementById('btnLogin').addEventListener('click', () => {
            const email = document.getElementById('email').value;
            const pass = document.getElementById('pass').value;
            if (!email || !pass) return alert("Complete los campos.");
            signInWithEmailAndPassword(auth, email, pass)
                .then((userCredential) => loginExitoso(userCredential.user))
                .catch((error) => alert("Credenciales incorrectas."));
        });

        document.getElementById('btnGoogle').addEventListener('click', () => {
            signInWithPopup(auth, provider)
                .then((result) => loginExitoso(result.user))
                .catch((error) => alert("Error con Google."));
        });
    </script>
</body>
</html>