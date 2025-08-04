<?php

include '../../conexion.php';

$id_producto = $_POST['id_producto'];
$cantidad_movimiento = $_POST['cantidad_movimiento'];
$tipo_movimiento = $_POST['tipo_movimiento']; // debe ser 'entrada' o 'salida'

// Validación básica
if (!in_array($tipo_movimiento, ['entrada', 'salida'])) {
    echo "Tipo de movimiento inválido.";
    exit;
}

$sql = "SELECT cantidad FROM productos_bodega WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $producto = $result->fetch_assoc();
    $cantidad_actual = $producto['cantidad'];

    // Determinar la nueva cantidad según tipo de movimiento
    if ($tipo_movimiento === 'entrada') {
        $nueva_cantidad = $cantidad_actual + $cantidad_movimiento;
    } else {
        $nueva_cantidad = $cantidad_actual - $cantidad_movimiento;
        if ($nueva_cantidad < 0) {
            echo "No puedes hacer una salida mayor al stock disponible.";
            exit;
        }
    }

    // 1. Actualizar cantidad en productos_bodega
    $sql_update = "UPDATE productos_bodega SET cantidad = ? WHERE id = ?";
    $stmt_update = $conexion->prepare($sql_update);
    $stmt_update->bind_param("ii", $nueva_cantidad, $id_producto);
    $stmt_update->execute();
    $stmt_update->close();

    // 2. Registrar movimiento en movimientos_bodega
    $sql_mov = "INSERT INTO movimientos_bodega (producto_id, tipo, cantidad) VALUES (?, ?, ?)";
    $stmt_mov = $conexion->prepare($sql_mov);
    $stmt_mov->bind_param("isi", $id_producto, $tipo_movimiento, $cantidad_movimiento);
    $stmt_mov->execute();
    $stmt_mov->close();

    // Redirigir
    header('Location: bodega.php?vista=productos');
    exit;

} else {
    echo "Producto no encontrado.";
}

$conexion->close();
?>
