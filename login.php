<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'inventarios';

    $conexion = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

    if (mysqli_connect_error()) {
        exit('Fallo en la conexión de MySQL: ' . mysqli_connect_error());
    }

    // Verificar las credenciales del usuario y obtener su tipo
    $stmt = $conexion->prepare('SELECT idusuario, passw, tipo FROM usuarios WHERE email = ? AND usuario = ?');
    $stmt->bind_param('ss', $email, $usuario);
    $stmt->execute();
    $stmt->bind_result($idusuario, $hashed_password, $tipo_usuario);
    $stmt->fetch();
    $stmt->close();

    // Mapeo del tipo de usuario numérico a nombre
    $tipos = [
        1 => 'Administrador',
        2 => 'Bodega',
        3 => 'Alimentos',
        4 => 'Biblioteca'
    ];
    $tipo_usuario_nombre = $tipos[$tipo_usuario] ?? '';

    if ($hashed_password && password_verify($password, $hashed_password)) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['idusuario'] = $idusuario;
        $_SESSION['tipo_usuario'] = $tipo_usuario_nombre; // Guardar como texto

        header('Location: inicio.php');
        exit();
    } else {
        echo "Usuario o contraseña incorrectos.";
    }

    $conexion->close();
}
?>

