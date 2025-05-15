<!DOCTYPE html>
<html lang="es">
<head>
  <link rel="stylesheet" href="css/style.css">
  <meta charset="UTF-8">
  <title>Formulario Contrato</title>
</head>
<body>
  <div class="container">
    <h1>Formulario de Contrato</h1>
    <form method="POST" action="">
      <input type="hidden" name="action" value="procesar">
      <label for="id">ID:</label>
      <input type="number" id="id" name="id" required>
      <label for="nombre">Nombre:</label>
      <input type="text" id="nombre" name="nombre" required>
      <label for="departamento">Departamento:</label>
      <input type="text" id="departamento" name="departamento" required>
      <label for="fechaIngreso">Fecha de Ingreso:</label>
      <input type="date" id="fechaIngreso" name="fechaIngreso" required>
      <label for="tipo">Tipo de Contrato:</label>
      <input type="text" id="tipo" name="tipo" required>
      <label for="contenido">Contenido:</label>
      <textarea id="contenido" name="contenido" required></textarea>
      <label for="firma">Firma:</label>
      <input type="text" id="firma" name="firma" required>
      <button type="submit">Enviar</button>
    </form>

    <?php
      require_once __DIR__ . '/../controller/ControladorRecursosHumanos.php';
      use Controller\ControladorRecursosHumanos;
      if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'procesar') {
          (new ControladorRecursosHumanos())->procesar($_POST);
      }
    ?>
  </div>
</body>
</html>
