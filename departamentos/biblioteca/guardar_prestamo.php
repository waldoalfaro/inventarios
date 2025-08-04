<?php
include '../../conexion.php';

$alumno_nombre = $_POST['alumno_nombre'];
$producto_nombre = $_POST['producto_nombre'];
$cantidad = $_POST['cantidad'];
$fecha_prestamo = $_POST['fecha_prestamo'];
$fecha_devolucion = $_POST['fecha_devolucion'];

// Obtener ID del alumno por nombre completo
$stmt_alumno = $conexion->prepare("SELECT id FROM alumnos WHERE CONCAT(carnet, ' - ', nombre) = ?");
$stmt_alumno->bind_param("s", $alumno_nombre);
$stmt_alumno->execute();
$stmt_alumno->bind_result($alumno_id);
$stmt_alumno->fetch();
$stmt_alumno->close();

// Obtener ID del producto por nombre
$stmt_producto = $conexion->prepare("SELECT id FROM productos_biblioteca WHERE nombre = ?");
$stmt_producto->bind_param("s", $producto_nombre);
$stmt_producto->execute();
$stmt_producto->bind_result($producto_id);
$stmt_producto->fetch();
$stmt_producto->close();

if ($alumno_id && $producto_id) {
    $stmt = $conexion->prepare("INSERT INTO prestamos (alumno_id, producto_id, cantidad, fecha_prestamo, fecha_devolucion) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiss", $alumno_id, $producto_id, $cantidad, $fecha_prestamo, $fecha_devolucion);

    if ($stmt->execute()) {
        header("Location: biblioteca.php");
    } else {
        echo "Error al registrar el préstamo: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "No se encontró el alumno o el producto.";
}

$conexion->close();
?>
