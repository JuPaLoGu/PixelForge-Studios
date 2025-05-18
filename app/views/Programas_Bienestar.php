<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Programas de bienestar</title>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Condensed:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="topbar">
        <div class="logo">
                <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png"
                    alt="LogoPixelForge">
        </div>
        <div class="topbar-left">
            <label for="">Programas de<br> bienestar</label>
        </div>
        <div class="topbar-center">
            <nav>
                <a href="Cursos_Virtuales.php" class="salto-linea">Cursos<br>virtuales</a>
                <a href="Contrato.php">Contrato</a>
                <a href="Programas_Bienestar.php" class="salto-linea">Programas de<br>bienestar</a>
            </nav>

        </div>
        <div class="topbar-right">
            <div class="input-container" id="usuario">
                <i class="fa-solid fa-user"></i>
                <div class="menu-desplegable" id="menu">
                    <a href="/public/logout.php">Cerrar sesión</a>
                </div>
            </div>

        </div>
    </div>

    <main class="inicio-container">
        <div class="logo-container">
            <img src="https://pixelforgestudio.com/wp-content/uploads/2023/05/Pixel-Forge-Studio-Logo.png"
                alt="LogoPixelForge">
        </div>
        <div class="texto-container">
            <h1>Lorem ipsum.</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipiscing elit fermentum eu scelerisque, erat consequat turpis
                commodo massa rutrum torquent fames dictumst,
                elementum feugiat placerat justo sollicitudin malesuada dui faucibus condimentum. Condimentum lobortis
                venenatis posuere facilisi cum eu porta iaculis
                convallis sociis vehicula tellus laoreet, egestas tempor mollis fermentum ornare augue aenean donec
                euismod purus potenti consequat. Non vel congue feugiat
                pellentesque iaculis erat hac parturient, in dui habitant duis nulla sem auctor augue, senectus
                convallis natoque sed cursus proin nam. Accumsan tempus id
                primis luctus cum hac dictumst volutpat, massa cubilia aliquet senectus nulla euismod taciti ligula,
                fringilla duis habitant ornare et tristique lobortis.</p>
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
    <footer>
        <img src="https://pixelforgestudio.com/wp-content/themes/pixelforgestudioventure/assets/public/images/pixel-div-bot.png"
            style="width: 100%; display: block;" alt="Imagen del footer">
    </footer>
</body>

</html>