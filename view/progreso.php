<!DOCTYPE html>
<html lang="es">
<head>
  <link rel="stylesheet" href="css/style.css">
  <meta charset="UTF-8">
  <title>Progreso</title>
</head>
<body>
  <div class="container">
    <h1>Progreso Empleado 1</h1>
    <div class="buttons">
      <?php
        require_once __DIR__ . '/../controller/ControladorProgreso.php';
        use Controller\ControladorProgreso;
        (new ControladorProgreso())->mostrar();
      ?>
    </div>
  </div>
</body>
</html>
