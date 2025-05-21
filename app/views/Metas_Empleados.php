<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Metas de empleados</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />

    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Condensed:wght@700&display=swap" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="style.css" />

    <style>
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
            background-color: #e2e8f0;
            color: #4a5568;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
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
            <label>Metas de <br>empleados</label>
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
        <a href="Nomina.php">Nómina</a>
        <a href="Metas_Empleados.php">Metas de empleados</a>
        <a href="Contratacion.php">Contratación</a>
        <a href="Beneficios_Metas.php">Beneficios por metas</a>
    </nav>

    <main class="inicio-container">

        <div class="texto-container">
            <h1>Empleados que han terminado el último módulo de cada curso</h1>
            <p>
                <?php
                // Incluye el archivo de configuración de la base de datos
                require_once('../../config/database.php');

                try {
                    // Obtiene la conexión a la base de datos
                    $db = Database::getInstance();
                    $pdo = $db->getConnection();

                    // Consulta SQL para obtener la cantidad de empleados que han terminado el último módulo de cada curso.
                    // Tablas usadas y sus campos relevantes:
                    // cursos (c): curso_id, titulo
                    // modulos (m): id, id_curso, orden, titulo
                    // examenes (e): id_modulo, empleado_id, aprobado, id_curso
                    // employees (em): empleado_id (para LEFT JOIN en caso de que necesitemos algo de empleados más adelante, aunque no es estrictamente necesario para este conteo)
                    // users (u): id, username (para filtrar por rol 'usuario' si es necesario)

                    $sql = "SELECT
                                c.titulo AS nombre_curso,
                                COUNT(DISTINCT ex.empleado_id) AS cantidad_empleados_terminaron_ultimo_modulo
                            FROM
                                cursos c
                            INNER JOIN
                                modulos m ON c.curso_id = m.id_curso -- Une cursos con sus módulos
                            INNER JOIN (
                                -- Subconsulta para encontrar el último módulo (el de mayor 'orden') de cada curso
                                SELECT
                                    id_curso,
                                    MAX(orden) AS ultimo_orden_modulo
                                FROM
                                    modulos
                                GROUP BY
                                    id_curso
                            ) AS ult_mod ON m.id_curso = ult_mod.id_curso AND m.orden = ult_mod.ultimo_orden_modulo -- Filtra para quedarnos solo con el último módulo
                            INNER JOIN
                                examenes ex ON m.id = ex.id_modulo AND ex.id_curso = c.curso_id AND ex.aprobado = 1 -- Une con exámenes, asegurando que el examen sea del último módulo del curso y esté aprobado
                            INNER JOIN
                                empleados em ON ex.empleado_id = em.empleado_id -- Une con empleados
                            INNER JOIN
                                users u ON em.usuario_id = u.id AND u.rol = 'usuario' -- Une con users para asegurar que es un 'usuario' (empleado)
                            GROUP BY
                                c.curso_id, c.titulo
                            ORDER BY
                                c.titulo";

                    // Prepara la consulta
                    $stmt = $pdo->prepare($sql);

                    // Ejecuta la consulta
                    $stmt->execute();

                    // Obtiene los resultados
                    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Muestra los resultados en una tabla
                    if (count($resultados) > 0) {
                        echo "<table>";
                        echo "<thead><tr><th>Nombre del Curso</th><th>Empleados que terminaron el Último Módulo</th></tr></thead>";
                        echo "<tbody>";
                        foreach ($resultados as $resultado) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($resultado['nombre_curso']) . "</td>";
                            echo "<td>" . htmlspecialchars($resultado['cantidad_empleados_terminaron_ultimo_modulo']) . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo "<p class='text-center text-gray-500 py-4'>No se encontraron cursos con empleados que hayan terminado su último módulo.</p>";
                    }
                } catch (PDOException $e) {
                    // Maneja errores de la base de datos
                    error_log("Error al obtener el conteo de empleados por último módulo: " . $e->getMessage());
                    echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative' role='alert'>
                            <strong class='font-bold'>Error:</strong>
                            <span class='block sm:inline'>Ocurrió un error al cargar la información: " . htmlspecialchars($e->getMessage()) . "</span>
                          </div>";
                }
                ?>
            </p>
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

            const closeMobileMenu = () => {
                if (mobileNav.classList.contains("active") && !mobileNav.classList.contains("closing")) {
                    mobileNav.classList.add("closing");
                    mobileNav.addEventListener("animationend", function handler() {
                        mobileNav.classList.remove("closing", "active");
                        mobileNav.removeEventListener("animationend", handler);
                    }, { once: true }); // Usar { once: true } para remover el event listener automáticamente

                    menuIcon.classList.remove("fa-times");
                    menuIcon.classList.add("fa-bars");
                    toggleBtn.classList.remove("active");
                    toggleBtn.style.color = "";
                    document.body.classList.remove("menu-open");
                }
            };

            usuario.addEventListener("click", function(e) {
                e.stopPropagation();
                const isOpen = usuario.classList.toggle("show-menu");
                usuario.classList.toggle("active");
                usuario.style.color = isOpen ? "#f73d66" : "";
            });

            document.addEventListener("click", function(e) {
                const clickEnUsuario = usuario.contains(e.target);
                const clickEnMenuHamburguesa = toggleBtn.contains(e.target) || mobileNav.contains(e.target);

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

            toggleBtn.addEventListener("click", function(e) {
                e.stopPropagation();
                if (document.body.classList.contains("menu-open")) {
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

            // No es necesario duplicar estos event listeners si ya están manejados arriba
            // const updateButtonColor = (button, isOpen) => { /* ... */ };
            // toggleBtn.addEventListener("click", function() { /* ... */ });
            // usuario.addEventListener("click", function() { /* ... */ });
        });
    </script>

</body>

</html>