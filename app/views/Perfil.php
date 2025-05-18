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
                <a href="beneficio.php">Bienestar</a>
                <a href="">Talleres</a>
                <a href="">Cursos</a>
                <a href="">Tour virtual</a>
                <a href="Metas_Empleados.php">Metas</a>
                <a href="CrearNomina.php">Nómina</a>
                <a href="Perfil.php">Editar Perfiles</a>
        </div>
        <div class="topbar-right">
            <div class="input-container" id="usuario">
                <i class="fa-solid fa-user"></i>
                <div class="menu-desplegable" id="menu">
                    <a href="Perfil.php">Perfil</a>
                    <a href="/public/logout.php">Cerrar sesión</a>
                </div>
            </div>

        </div>
    </div>

    <main class="inicio-container">
        <div class="texto-container">
            <h1>Lorem ipsum.</h1>
            <form method="POST" action="">
                
                <h2>Editar Usuario</h2>

                <label for="user_id">ID:</label>
                <input type="text" id="id" name="id"><br>
                </select><br>

                <label for="rol">Rol:</label>
                <select name="rol" id="rol" required>
                    <option value="null">-</option>
                    <option value="empleado">empleado</option>
                    <option value="usuario">Usuario</option>
                </select><br>

                <label for="estado">Estado:</label>
                <select name="estado" id="estado" required>
                    <option value="null">-</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select><br>

                <button type="submit">Actualizar</button>
            </form>

            <?php
            require_once '../controllers/PerfilController.php';
            $perfilController = new PerfilController();
            $perfilController->mostrarUsuarios();
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $perfilController->actualizarUsuario();
            }
            exit;
            ?>    

</body>

</html>