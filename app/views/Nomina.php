<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Nomina</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Condensed:wght@700&display=swap" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css" />

    <style>
        /* Mantén tus estilos existentes */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }
        .texto-container {
            background-color: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 25px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #e2e8f0; /* bg-gray-200 */
            color: #4a5568; /* text-gray-700 */
            font-size: 0.75rem; /* text-xs */
            font-weight: 600; /* font-semibold */
            text-transform: uppercase; /* uppercase */
            letter-spacing: 0.05em; /* tracking-wider */
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-center {
            text-align: center;
        }
        .text-gray-500 {
            color: #a0a0a0;
        }
        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        .bg-red-100 { background-color: #fee2e2; }
        .border-red-400 { border-color: #f87171; }
        .text-red-700 { color: #b91c1c; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .rounded { border-radius: 0.25rem; }
        .relative { position: relative; }
        .font-bold { font-weight: bold; }
        .block { display: block; }
        .sm\:inline { display: inline; }
        .overflow-x-auto {
            overflow-x: auto;
        }

        /* Estilos para el nuevo formulario de filtro */
        .filter-form {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f0f0f0;
            border-radius: 8px;
            align-items: center;
            justify-content: center;
        }
        .filter-form label {
            font-weight: bold;
            color: #555;
        }
        .filter-form select, .filter-form input[type="submit"] {
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
        }
        .filter-form input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }
        .filter-form input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="topbar">
        <div class="logo">
            <a href="InicioEmpleado.php">
                <img src="https://pixelforgestudio.com/wp-content/uploads/2024/11/Pixel-Forge-Studio-Header-Logo.png" alt="LogoPixelForge" />
            </a>
        </div>

        <div class="topbar-left">
            <label>Nomina</label>
        </div>

        <div class="topbar-center">
            <nav class="nav-links">
                <a href="Programas_Bienestar.php">Bienestar</a>
                <a href="../../ModuloCursos/Cursos_VirtualesAdmin.php">Cursos</a>
                <a href="Metas_Empleados.php">Metas</a>
                <a href="Nomina.php">Nómina</a>
                <a href="Perfil.php">Editar Perfiles</a>
            </nav>
        </div>

        <div class="topbar-right">
            <div class="menu-toggle" id="menuToggle">
                <i class="fa fa-bars" id="menuIcon"></i>
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
    </div>

    <nav class="mobile-menu" id="mobileNav">
        <a href="beneficio.php">Bienestar</a>
        <a href="#">Cursos</a>
        <a href="#">Tour virtual</a>
        <a href="Metas_Empleados.php">Metas</a>
        <a href="Nomina.php">Nómina</a>
        <a href="Perfil.php">Editar Perfiles</a>
    </nav>

    <main class="inicio-container">
        <div class="logo-container">
            <img src="https://pixelforgestudio.com/wp-content/uploads/2023/05/Pixel-Forge-Studio-Logo.png" alt="LogoPixelForge" />
        </div>

        <div class="texto-container">
            <h1>Reporte de Nómina: Quizzes Completados por Usuarios</h1>

            <form method="GET" action="Nomina.php" class="filter-form">
                <label for="mes">Filtrar por Mes:</label>
                <select name="mes" id="mes">
                    <option value="">Todos los meses</option>
                    <?php
                    $meses = [
                        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                    ];
                    $mes_seleccionado = isset($_GET['mes']) ? (int)$_GET['mes'] : '';
                    foreach ($meses as $num => $nombre) {
                        $selected = ($mes_seleccionado === $num) ? 'selected' : '';
                        echo "<option value='{$num}' {$selected}>{$nombre}</option>";
                    }
                    ?>
                </select>

                <label for="anio">Año:</label>
                <select name="anio" id="anio">
                    <option value="">Todos los años</option>
                    <?php
                    $anio_actual = date("Y");
                    $anio_inicio = 2020; // Puedes ajustar el año de inicio
                    $anio_seleccionado = isset($_GET['anio']) ? (int)$_GET['anio'] : '';

                    for ($anio = $anio_actual; $anio >= $anio_inicio; $anio--) {
                        $selected = ($anio_seleccionado === $anio) ? 'selected' : '';
                        echo "<option value='{$anio}' {$selected}>{$anio}</option>";
                    }
                    ?>
                </select>

                <input type="submit" value="Filtrar">
            </form>

            <?php
            // Asegúrate de que esta ruta sea correcta para tu archivo Database.php
            require_once '../../config/database.php';

            try {
                $db = Database::getInstance();
                $pdo = $db->getConnection();

                // Obtener el mes y el año del filtro si están presentes en la URL
                $mes_filtro = isset($_GET['mes']) && $_GET['mes'] !== '' ? (int)$_GET['mes'] : null;
                $anio_filtro = isset($_GET['anio']) && $_GET['anio'] !== '' ? (int)$_GET['anio'] : null;

                // Construir la consulta SQL base
                $sql = "SELECT
                            u.username,
                            'Quiz Completado' AS concepto,
                            ex.fecha_examen AS fecha_quiz
                        FROM
                            users u
                        INNER JOIN
                            empleados e ON u.id = e.usuario_id
                        INNER JOIN
                            examenes ex ON e.empleado_id = ex.empleado_id
                        WHERE
                            u.rol = 'usuario'
                            AND ex.aprobado = 1";

                // Agregar condiciones de filtro si se seleccionó un mes o año
                if ($mes_filtro) {
                    $sql .= " AND MONTH(ex.fecha_examen) = :mes_filtro";
                }
                if ($anio_filtro) {
                    $sql .= " AND YEAR(ex.fecha_examen) = :anio_filtro";
                }

                $sql .= " ORDER BY u.username, ex.fecha_examen";

                // Preparar la consulta
                $stmt = $pdo->prepare($sql);

                // Bindear los parámetros si existen
                if ($mes_filtro) {
                    $stmt->bindParam(':mes_filtro', $mes_filtro, PDO::PARAM_INT);
                }
                if ($anio_filtro) {
                    $stmt->bindParam(':anio_filtro', $anio_filtro, PDO::PARAM_INT);
                }

                // Ejecutar la consulta
                $stmt->execute();

                // Obtener todos los resultados como un array asociativo
                $quizzes_completados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($quizzes_completados) > 0) {
            ?>
                    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                        <table class="min-w-full leading-normal shadow-md rounded-lg overflow-hidden">
                            <thead class="bg-gray-200 text-gray-700">
                                <tr>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Nombre de Usuario</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Concepto</th>
                                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-xs font-semibold uppercase tracking-wider">Fecha de Completado del Quiz</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <?php foreach ($quizzes_completados as $registro) { ?>
                                    <tr>
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm"><?php echo htmlspecialchars($registro['username']); ?></td>
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm"><?php echo htmlspecialchars($registro['concepto']); ?></td>
                                        <td class="px-5 py-5 border-b border-gray-200 text-sm"><?php echo htmlspecialchars($registro['fecha_quiz']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
            <?php
                } else {
                    echo "<p class='text-center text-gray-500 py-4'>Ningún usuario con rol 'usuario' ha completado un quiz en el período seleccionado.</p>";
                }
            } catch (PDOException $e) {
                echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative' role='alert'>
                <strong class='font-bold'>Error:</strong>
                <span class='block sm:inline'>Ocurrió un error al consultar la base de datos: " . htmlspecialchars($e->getMessage()) . "</span>
              </div>";
            }
            ?>
        </div>
    </main>

    <footer>
        <img src="https://pixelforgestudio.com/wp-content/themes/pixelforgestudioventure/assets/public/images/pixel-div-bot.png" style="width: 100%; display: block;" alt="Imagen del footer" />
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const usuario = document.getElementById("usuario");
            const menu = document.getElementById("menu");
            const toggleBtn = document.querySelector(".menu-toggle");
            const menuIcon = toggleBtn.querySelector("i");
            const mobileNav = document.getElementById("mobileNav");

            // Verifica si es un dispositivo táctil
            const isTouchDevice = () => window.matchMedia("(pointer: coarse)").matches;

            // Función para cerrar el menú móvil con animación
            function closeMobileMenu() {
                if (mobileNav.classList.contains("active") && !mobileNav.classList.contains("closing")) {
                    mobileNav.classList.add("closing");

                    mobileNav.addEventListener("animationend", function handler() {
                        mobileNav.classList.remove("closing");
                        mobileNav.classList.remove("active");
                        mobileNav.removeEventListener("animationend", handler);
                    });

                    // Restaurar icono y color al cerrar
                    menuIcon.classList.remove("fa-times");
                    menuIcon.classList.add("fa-bars");
                    toggleBtn.classList.remove("active");
                    toggleBtn.style.color = ""; // Color por defecto
                    document.body.classList.remove("menu-open");
                }
            }

            // Alternar visibilidad del menú de usuario (RRHH)
            usuario.addEventListener("click", function(e) {
                e.stopPropagation();
                const isOpen = usuario.classList.toggle("show-menu");
                usuario.classList.toggle("active");

                // Cambiar color según estado
                if (isOpen) {
                    usuario.style.color = "#f73d66";
                } else {
                    usuario.style.color = "";
                }
            });

            // Cerrar menús si se hace clic fuera
            document.addEventListener("click", function(e) {
                const clickEnUsuario = usuario.contains(e.target);
                const clickEnMenuHamburguesa = toggleBtn.contains(e.target) || mobileNav.contains(e.target);

                // Timeout evita conflictos visuales
                setTimeout(() => {
                    if (!clickEnMenuHamburguesa) {
                        closeMobileMenu();
                    }

                    if (!clickEnUsuario) {
                        usuario.classList.remove("show-menu", "active");
                        usuario.style.color = "";
                    }
                }, 0);
            });

            // Mostrar u ocultar el menú móvil (hamburguesa)
            toggleBtn.addEventListener("click", function(e) {
                e.stopPropagation();

                if (document.body.classList.contains("menu-open")) {
                    toggleBtn.style.color = "";
                    closeMobileMenu();
                } else {
                    toggleBtn.classList.add("active");
                    menuIcon.classList.remove("fa-bars");
                    menuIcon.classList.add("fa-times");
                    document.body.classList.add("menu-open");
                    mobileNav.classList.add("active");
                    toggleBtn.style.color = "#f73d66";
                }
            });

            // Función para cambiar el color de botón según estado
            const updateButtonColor = (button, isOpen) => {
                if (button, isOpen) {
                    button.style.color = "#ffffff"; // Color por defecto
                } else {
                    button.style.color = "#f73d66"; // Color activo
                }
            };

            // Aplicar cambios al botón hamburguesa
            toggleBtn.addEventListener("click", function() {
                const isOpen = toggleBtn.classList.contains("active");
                updateButtonColor(toggleBtn, !isOpen);
            });

            // Aplicar cambios al botón del usuario
            usuario.addEventListener("click", function() {
                const isOpen = usuario.classList.contains("active");
                updateButtonColor(usuario, !isOpen);
            });
        });
    </script>

</body>

</html>