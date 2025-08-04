<?php
include '../../conexion.php'; // Asegúrate de tener la conexión bien configurada

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $carnet = trim($_POST['carnet']);

    if (!empty($nombre) && !empty($carnet)) {
        $sql = "INSERT INTO alumnos (nombre, carnet) VALUES (?, ?)";
        $stmt = mysqli_prepare($conexion, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $nombre, $carnet);
            $resultado = mysqli_stmt_execute($stmt);

            if ($resultado) {
                header("Location: biblioteca.php");
                exit();
            } else {
                echo "Error al guardar el alumno.";
            }
        } else {
            echo "Error al preparar la consulta.";
        }
    } else {
        echo "Nombre y carnet son obligatorios.";
    }
} else {
    echo "Acceso no permitido.";
}

mysqli_close($conexion);
?>
