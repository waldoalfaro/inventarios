<?php
include '../../conexion.php';

$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];
$precio_unitario = $_POST['precio_unitario'];

$sql = "INSERT INTO productos_biblioteca (nombre, descripcion, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssid", $nombre, $descripcion, $cantidad, $precio_unitario);

if ($stmt->execute()) {
    header("Location: biblioteca.php");
    exit();
} else {
    echo "Error al guardar el producto: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
