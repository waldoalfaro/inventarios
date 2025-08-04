<?php
include '../../conexion.php';

$nombre = $_POST['nombre'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$cantidad = $_POST['cantidad'] ?? 0;
$precio = $_POST['precio'] ?? 0.00;

// Validamos los datos antes de insertar
if (!empty($nombre) && !empty($descripcion) && is_numeric($cantidad) && is_numeric($precio)) {
    $stmt = $conexion->prepare("INSERT INTO productos_bodega (nombre, descripcion, cantidad, precio) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssid", $nombre, $descripcion, $cantidad, $precio);

    if ($stmt->execute()) {
        header("Location: bodega.php?vista=productos");
        exit;
    } else {
        echo "Error al guardar producto: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Por favor completa todos los campos correctamente.";
}
?>
