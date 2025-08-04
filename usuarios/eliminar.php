<?php
include '../conexion.php'; 

if (isset($_GET['id'])) {
    $id = $_GET['id'];


    $sql = "DELETE FROM usuarios WHERE idusuario = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id); 
        $stmt->execute();
        $stmt->close();
    }

    // Redirigir a la lista de usuarios
    header('Location: usuario.php');
    exit();
}
?>
