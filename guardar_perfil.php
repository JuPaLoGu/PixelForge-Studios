<?php
include 'bd.php';

$id = $_POST['id'];
$rol = $_POST['rol'];
$estado = $_POST['estado'];

$sql = "UPDATE users SET rol = ?, estado = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $rol, $estado, $id);
$stmt->execute();

header("Location: principal.php");

exit;
?>
