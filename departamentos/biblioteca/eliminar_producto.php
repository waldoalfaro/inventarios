<?php
include '../../conexion.php';

$id = $_GET['id'];

$sql = "DELETE FROM productos_biblioteca WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: biblioteca.php");
} else {
    echo "Error al eliminar el producto: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
