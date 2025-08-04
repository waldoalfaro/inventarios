<?php
include '../../conexion.php';

$id_producto = $_POST['id_producto'];
$cantidad_movimiento = (int) $_POST['cantidad_movimiento'];
$tipo_movimiento = $_POST['tipo_movimiento']; // 'entrada' o 'salida'

// Obtener la cantidad actual
$sql = "SELECT cantidad FROM productos_biblioteca WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$resultado = $stmt->get_result();
$producto = $resultado->fetch_assoc();

if (!$producto) {
    echo "Producto no encontrado.";
    exit;
}

$cantidad_actual = $producto['cantidad'];

// Calcular nueva cantidad según tipo
$nueva_cantidad = $tipo_movimiento === 'entrada'
    ? $cantidad_actual + $cantidad_movimiento
    : $cantidad_actual - $cantidad_movimiento;

if ($nueva_cantidad < 0) {
    echo "<script>
        alert('No puedes retirar más productos de los que hay en inventario.');
        window.location.href = 'biblioteca.php?vista=productos';
    </script>";
    exit;
}

// Actualizar producto
$update = $conexion->prepare("UPDATE productos_biblioteca SET cantidad = ? WHERE id = ?");
$update->bind_param("ii", $nueva_cantidad, $id_producto);
$update->execute();

// Registrar en movimientos
$insert = $conexion->prepare("INSERT INTO movimientos_biblioteca (producto_id, tipo, cantidad) VALUES (?, ?, ?)");
$insert->bind_param("isi", $id_producto, $tipo_movimiento, $cantidad_movimiento);
$insert->execute();

echo "<script>
    alert('Movimiento registrado exitosamente.');
    window.location.href = 'biblioteca.php?vista=productos';
</script>";
