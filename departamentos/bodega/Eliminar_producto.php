
<?php
include '../../conexion.php';

$id = $_GET['id'];

$sql = "DELETE FROM productos_bodega WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: bodega.php");
} else {
    echo "Error al eliminar el producto: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
