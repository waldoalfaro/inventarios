<?php
include '../../conexion.php';

$producto_id = $_POST['producto_id'];
$cantidad = $_POST['cantidad'];
$cliente = $_POST['cliente'];
$precio_total = $_POST['precio_total']; // ← importante

$sql = "INSERT INTO ventas (producto_id, cantidad, cliente, precio_total) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("iisd", $producto_id, $cantidad, $cliente, $precio_total);

if ($stmt->execute()) {
    header("Location: biblioteca.php?vista=ventas");
} else {
    echo "Error al registrar la venta: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
