<?php
// Incluye el archivo de configuración de la base de datos
require_once '../../config/database.php'; // Asegúrate de que este archivo define $conn

class PerfilController
{

    public function mostrarUsuarios()
    {
        try {
            // Obtiene la conexión a la base de datos usando el Singleton
            $db = Database::getInstance();
            $conn = $db->getConnection();

            // Crea la consulta SQL para seleccionar los campos deseados de la tabla de usuarios
            $sql = "SELECT id, username, mail, estado, rol FROM users";

            // Prepara la consulta SQL
            $stmt = $conn->prepare($sql);

            // Ejecuta la consulta
            $stmt->execute();

            // Obtiene todos los resultados de la consulta como un array asociativo
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Verifica si se encontraron usuarios
            if (count($usuarios) > 0) {
                // Imprime los encabezados de la tabla
                echo "<style>
                        .tabla-usuarios {
                            margin: 20px auto; /* Centrar la tabla horizontalmente */
                            background-color: white;
                            border-collapse: collapse; /* Colapsar los bordes de la tabla */
                            width: 80%; /* Ancho de la tabla (ajusta según sea necesario) */
                            max-width: 800px; /* Ancho máximo para la tabla */
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra suave */
                        }
                        .tabla-usuarios th, .tabla-usuarios td {
                            border: 1px solid #ddd; /* Bordes para las celdas */
                            padding: 8px;
                            text-align: left;
                        }
                        .tabla-usuarios th {
                            background-color: #f0f0f0; /* Color de fondo para los encabezados */
                        }
                        .tabla-usuarios tr:hover {
                            background-color: #f5f5f5; /* Color de fondo al pasar el mouse sobre las filas */
                        }
                    </style>";
                echo "<table class='tabla-usuarios'>";
                echo "<thead><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Estado</th><th>Rol</th></tr></thead>";
                echo "<tbody>";
                // Itera sobre el array de usuarios e imprime los datos en una tabla
                foreach ($usuarios as $usuario) {
                    echo "<tr>";
                    echo "<td>" . $usuario['id'] . "</td>";
                    echo "<td>" . $usuario['username'] . "</td>";
                    echo "<td>" . $usuario['mail'] . "</td>";
                    echo "<td>" . $usuario['estado'] . "</td>";
                    echo "<td>" . $usuario['rol'] . "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                // Imprime un mensaje si no se encontraron usuarios
                echo "No se encontraron usuarios.";
            }
        } catch (PDOException $e) {
            // Captura cualquier excepción de PDO e imprime el error
            //echo "Error al obtener la lista de usuarios: " . $e->getMessage();
        }
    }

    public function actualizarUsuario()
    {

        $db = Database::getInstance();
        $conn = $db->getConnection();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            $id = $_POST['id'];
            $rol = $_POST['rol'];
            $estado = $_POST['estado'];

            $sql = "UPDATE users SET rol = ?, estado = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $rol);
            $stmt->bindParam(2, $estado);
            $stmt->bindParam(3, $id);
            $stmt->execute();

            header("Location: Perfil.php"); // Asegúrate de que la redirección sea correcta
            exit;
        }
    }
}
