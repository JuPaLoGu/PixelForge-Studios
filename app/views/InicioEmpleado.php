<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Página principal</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Condensed:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="topbar">
        <div class="logo">
            <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge">


        </div>
        <div class="topbar-center">
            <nav>
                <a href="Programas_Bienestar.php">Bienestar</a>
                <a href="../../ModuloCursos/Cursos_VirtualesAdmin.php">Cursos</a>
                <a href="Metas_Empleados.php">Metas</a>
                <a href="Nomina.php">Nómina</a>
                <a href="Perfil.php">Editar Perfiles</a>


        </div>
        <div class="topbar-right">
            <div class="input-container" id="usuario">
                <i class="fa-solid fa-user"></i>
                <div class="menu-desplegable" id="menu">
                    <a href="../../public/logout.php">Cerrar sesión</a>
                </div>
            </div>

        </div>
    </div>

    <main class="inicio-container">
        <div class="logo-container">
            <img src="https://pixelforgestudio.com/wp-content/uploads/2023/05/Pixel-Forge-Studio-Logo.png" alt="LogoPixelForge">
        </div>
        <div class="texto-container">
            <h1>Pixel Forge Studios: Forjando Mundos Digitales.</h1>
            <p>Somos un estudio de desarrollo de videojuegos apasionado por crear experiencias inmersivas para múltiples plataformas:
                PC, consolas y dispositivos móviles. Impulsados por el éxito de nuestros títulos más recientes, estamos construyendo una 
                base sólida para un futuro aún más emocionante.</p>
        </div>
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const usuario = document.getElementById('usuario');
            const menu = document.getElementById('menu');

            // Maneja el clic sobre el icono o el texto "RRHH"
            usuario.addEventListener('click', function(e) {
                e.stopPropagation(); // Evita que el clic fuera del contenedor lo oculte
                usuario.classList.toggle('show-menu'); // Alterna el estado del menú
            });

            // Cierra el menú si se hace clic fuera del contenedor
            document.addEventListener('click', function(e) {
                if (!usuario.contains(e.target)) {
                    usuario.classList.remove('show-menu'); // Oculta el menú si se hace clic fuera
                }
            });
        });
    </script>
</body>

</html>