<?php
include '../conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idusuario = $_POST['idusuario']; 
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $tipo_usuario = $_POST['tipo_usuario'];

    if ($conexion) {

        $sql = "UPDATE usuarios SET usuario = ?, email = ?, tipo = ? WHERE idusuario = ?";
        $stmt = $conexion->prepare($sql);

        // Vincular los parámetros de la consulta
        $stmt->bind_param("sssi", $usuario, $correo, $tipo_usuario, $idusuario); // 'sssi' para tres cadenas y un entero

        if ($stmt->execute()) {
            
            header('Location: usuario.php');
            exit(); 
        } else {
            echo "Error al actualizar el usuario.";
        }

        // Cerrar la consulta
        $stmt->close();
    } else {
        echo "Error en la conexión a la base de datos.";
    }
}
?>

