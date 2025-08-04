<?php
// conexion.php ya hace session_start()
include 'conexion.php';

// 1) Redirigir si no está autenticado
if (empty($_SESSION['idusuario'])) {
    header("Location: login.php");
    exit();
}

// 2) Normalizar el tipo de usuario
$tipo = isset($_SESSION['tipo_usuario'])
       ? ucfirst(strtolower($_SESSION['tipo_usuario']))
       : '';



// Puedes inspeccionar aquí con var_dump($tipo) si sigue sin coincidir.

$isAdmin    = $tipo === 'Administrador';
$isBodega   = $tipo === 'Bodega';
$isBiblio   = $tipo === 'Biblioteca';
$isAlimentos= $tipo === 'Alimentos';




?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>INJI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/inventarios/inicio.php">INJI</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        <li class="nav-item">
          <a class="nav-link" href="/inventarios/perfil.php"></a>
        </li>

        <?php if ($isAdmin): ?>
          <li class="nav-item">
            <a class="nav-link" href="/inventarios/usuarios/usuario.php">Usuarios</a>
          </li>
        <?php endif; ?>

        <?php if ($isAdmin || $isBodega): ?>
        <li class="nav-item">
            <a class="nav-link" href="/inventarios/departamentos/bodega/bodega.php">Bodega</a>
        </li>
        <?php endif; ?>

         

        <?php if ($isAdmin || $isBiblio): ?>
        <li class="nav-item">
            <a class="nav-link" href="/inventarios/departamentos/biblioteca/biblioteca.php">Biblioteca</a>
        </li>
        <?php endif; ?>

        <?php if ($isAdmin || $isAlimentos): ?>
        <li class="nav-item">
            <a class="nav-link" href="/inventarios/departamentos/alimentos/alimentos.php">Alimentos</a>
        </li>
        <?php endif; ?>

        <?php if ($isAdmin): ?>
          <li class="nav-item">
            <a class="nav-link" href="/inventarios/reportes/reportes.php">Reportes</a>
          </li>
        <?php endif; ?>
      </ul>

        <a class="nav-link text-warning" href="/inventarios/salir.php">Salir</a>
     
    </div>
  </div>
</nav>






<!-- ✅ Script correcto para que funcione el dropdown -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>

