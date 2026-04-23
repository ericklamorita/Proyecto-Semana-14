<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema | Villa de Libros</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-login"> <div class="overlay"></div> <div class="glass-container" style="max-width: 450px; margin: 5vh auto;">
        <h1 id="login-title" style="color: var(--primary-color); margin-bottom: 5px;">Bienvenido</h1>
        <p class="subtitle" style="color: var(--text-muted); margin-bottom: 30px;">Ingrese sus credenciales</p>

        <div class="input-group">
            <input type="email" id="email" placeholder="Correo electrónico">
        </div>
        <div class="input-group">
            <input type="password" id="pass" placeholder="Contraseña">
        </div>

        <button id="btnLogin" class="btn btn-primary">Iniciar Sesión</button>

        <div style="margin: 20px 0; color: var(--text-muted); font-size: 0.8rem; display: flex; align-items: center; justify-content: center; gap: 10px;">
            <hr style="flex-grow: 1; border: 0.5px solid rgba(255,255,255,0.1);"> o continuar con <hr style="flex-grow: 1; border: 0.5px solid rgba(255,255,255,0.1);">
        </div>

        <button id="btnGoogle" class="btn" style="background: white; color: #444; display: flex; align-items: center; justify-content: center; gap: 10px;">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/500px-Google_%22G%22_logo.svg.png" alt="G" style="width: 18px;">
            ACCEDER CON GOOGLE (YA EXISTENTE)
        </button>

        <div id="seccion-registro">
            <div style="margin: 20px 0; color: var(--text-muted); font-size: 0.8rem; display: flex; align-items: center; justify-content: center; gap: 10px;">
                <hr style="flex-grow: 1; border: 0.5px solid rgba(255,255,255,0.1);"> o si eres nuevo <hr style="flex-grow: 1; border: 0.5px solid rgba(255,255,255,0.1);">
            </div>
            <div class="footer-link">
                <p style="margin-bottom: 10px; color: var(--text-muted);">¿Aún no vives en la Villa?</p>
                <a href="registro.php" style="display: block; text-decoration: none; color: var(--primary-color); background: rgba(0, 212, 255, 0.1); padding: 12px; border-radius: 10px; border: 1px solid var(--primary-color); font-weight: bold; transition: all 0.3s;">
                    CREAR CUENTA NUEVA
                </a>
            </div>
        </div>

        <div class="footer-link" style="margin-top: 25px;">
            <a href="../seleccion.php" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">← Volver a selección</a>
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

        document.getElementById('login-title').innerText = "Acceso " + (rolElegido === 'trabajador' ? "Personal" : "Clientes");

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
                        window.location.href = (rolElegido === 'trabajador') ? '../index.php' : '../catalogo.php';
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