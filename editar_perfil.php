<?php
session_start();
include 'bd.php';

$id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>


<h2>Editar perfil</h2>
<form action="guardar_perfil.php" method="POST">
  <input type="hidden" name="id" value="<?= $user['id'] ?>">
  Nombre de usuario: <?= htmlspecialchars($user['username']) ?><br>
  Correo electrónico: <?= htmlspecialchars($user['mail']) ?><br><br>

  Rol:
  <select name="rol">
    <option value="usuario" <?= $user['rol'] == 'usuario' ? 'selected' : '' ?>>Usuario</option>
    <option value="empleado" <?= $user['rol'] == 'empleado' ? 'selected' : '' ?>>Empleado</option>
    <option value="admin" <?= $user['rol'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
  </select><br>

  Estado:
  <select name="estado">
    <option value="activo" <?= $user['estado'] == 'activo' ? 'selected' : '' ?>>Activo</option>
    <option value="inactivo" <?= $user['estado'] == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
  </select><br><br>

  <input type="submit" value="Guardar cambios">
</form>
