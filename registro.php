<?php
session_start();

// Credenciales de conexión a la base de datos
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'inventarios';

// Conexión a la base de datos
$conexion = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if (mysqli_connect_error()) {
    exit('Fallo en la conexión de MySQL: ' . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario']);
    $email = trim($_POST['email']);
    $contrasena = trim($_POST['contrasena']);

    if (empty($usuario) || empty($email) || empty($contrasena)) {
        $_SESSION['messages'][] = "Todos los campos son obligatorios.";
    } else {
        // Verificar si el correo ya está registrado
        $stmt = $conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($emailExistente);
        $stmt->fetch();
        $stmt->close();

        if ($emailExistente > 0) {
            $_SESSION['messages'][] = "El correo electrónico ya está registrado.";
        } else {
            // Encriptar la contraseña
            $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario en la base de datos
            $sql = "INSERT INTO usuarios (usuario, email, passw, tipo, estado) VALUES (?, ?, ?, 'usuario', 'activo')";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param('sss', $usuario, $email, $contrasenaHash);

            if ($stmt->execute()) {
                $_SESSION['messages'][] = "Registro exitoso. ¡Ahora puedes iniciar sesión!";
                header("Location: index.html");
                exit();
            } else {
                $_SESSION['messages'][] = "Hubo un error al registrar el usuario.";
            }
            $stmt->close();
        }
    }
}

$messages = $_SESSION['messages'] ?? [];
unset($_SESSION['messages']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <form class="login-form" action="index.html" method="POST">
            <h2>Registro de Usuario</h2>
            
            <?php if (!empty($messages)): ?>
                <div class="error-message">
                    <?php foreach ($messages as $message): ?>
                        <p><?php echo htmlspecialchars($message); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <i class="fas fa-user icon"></i>
                <input type="text" name="usuario" placeholder="Nombre de Usuario" required>
            </div>
            
            <div class="form-group">
                <i class="fas fa-envelope icon"></i>
                <input type="email" name="email" placeholder="Correo Electrónico" required>
            </div>
            
            <div class="form-group">
                <i class="fas fa-lock icon"></i>
                <input type="password" name="contrasena" id="password" placeholder="Contraseña" required>
                <i class="toggle-password" id="togglePassword"></i>
            </div>                              
            
            <button type="submit" class="btn">Registrarse</button>

            <div class="login-link">
                <p>¿Ya tienes cuenta? <a href="index.html" class="login-text">¡Inicia sesión aquí!</a></p>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            let passwordInput = document.getElementById('password');
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                this.classList.add('active');
            } else {
                passwordInput.type = "password";
                this.classList.remove('active');
            }
        });
    </script>
</body>
</html>
