<?php 

include 'conexion.php';



// Obtener datos del usuario
$stmt = $conexion->prepare('SELECT passw, email FROM usuarios WHERE idusuario = ?');
$stmt->bind_param('i', $_SESSION['idusuario']);
$stmt->execute();
$stmt->bind_result($passw, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil Usuario</title>
    
    <!-- Estilos -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
<div class="login-container">
    <nav class="navtop">
        <h1 class="titulo-instituto">
            Sistema de Control de Inventario del Instituto Nacional José Ingenieros
        </h1>
        <div class="nav-links">
            <a href="inicio.html"><i class="fas fa-home"></i> Inicio</a>
            <a href="perfil.php"><i class="fas fa-user-circle"></i> Perfil</a>
            <a href="cerrar.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
        </div>
    </nav>



        <div class="content">
            <h2>Información del Usuario</h2>
            <p>Estos son los datos registrados de tu cuenta:</p>
            <table>
                <tr>
                    <td><strong>Usuario:</strong></td>
                    <td><?= $_SESSION['usuario'] ?></td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td><?= $email ?></td>
                </tr>
            </table>
        </div>
    </div>
    </div>
</body>
</html>
