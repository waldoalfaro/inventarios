<?php
include '../conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $tipo_usuario = $_POST['tipo_usuario'];

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    try {

        if ($conexion) {
            $sql = "INSERT INTO usuarios (usuario, email, passw, tipo) VALUES (?, ?, ?, ?)";

            // Preparar la consulta
            $stmt = $conexion->prepare($sql);
            
            $stmt->bind_param("ssss", $usuario, $correo, $password_hash, $tipo_usuario);
            
            if ($stmt->execute()) {
                echo "<script>alert('Usuario registrado con éxito'); window.location.href='usuario.php';</script>";
            } else {
                echo "<script>alert('Error al registrar usuario'); window.history.back();</script>";
            }

            // Cerrar la consulta
            $stmt->close();
        } else {
            echo "Error en la conexión a la base de datos.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

