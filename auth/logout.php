<?php
session_start();
session_destroy(); // Esto limpia la sesión de PHP
?>

<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/12.9.0/firebase-app.js";
    import { getAuth, signOut }
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

    signOut(auth).then(() => {
        window.location.href = "login.php"; 
    });
</script>