<?php
// ACTIVAR REPORTES DE ERRORES
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// INICIAR BUFFER DE SALIDA PARA EVITAR ERRORES
ob_start();

require '../vendor/autoload.php';
require '../conexion.php';

use Dompdf\Dompdf;

// Fechas del mes actual
$fecha_inicio = date('Y-m-01');
$fecha_fin = date('Y-m-t');

// Comenzar HTML
?>

<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        color: #2c3e50;
    }

    h1 {
        text-align: center;
        color: #1a5276;
        border-bottom: 2px solid #1a5276;
        padding-bottom: 5px;
        margin-bottom: 30px;
    }

    h2 {
        background-color: #f2f2f2;
        color: #1a5276;
        padding: 8px;
        border-left: 5px solid #1a5276;
        margin-top: 40px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        margin-bottom: 20px;
    }

    table, th, td {
        border: 1px solid #aaa;
    }

    th {
        background-color: #d6eaf8;
        color: #154360;
        text-align: left;
        padding: 5px;
    }

    td {
        padding: 5px;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>

<h1>Corte Mensual - <?= date('F Y') ?></h1>

<!-- STOCK ACTUAL -->
<h2>Stock Actual</h2>
<table>
<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Cantidad</th><th>Fecha</th></tr>
<?php
$res = $conexion->query("SELECT * FROM alimentos");
while ($r = $res->fetch_assoc()) {
    echo "<tr><td>{$r['id']}</td><td>{$r['nombre']}</td><td>{$r['descripcion']}</td><td>{$r['stock_gramos']}</td><td>{$r['creado_en']}</td></tr>";
}
?>
</table>

<!-- ENTRADAS -->
<h2>Entradas de Alimentos</h2>
<table>
<tr><th>ID</th><th>Alimento</th><th>Cantidad</th><th>Fecha</th><th>Unidad</th><th>Precio</th></tr>
<?php
$res = $conexion->query("
    SELECT e.*, a.nombre 
    FROM entradas_alimentos e 
    JOIN alimentos a ON e.alimento_id = a.id 
    WHERE fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'
");
while ($r = $res->fetch_assoc()) {
    echo "<tr><td>{$r['id']}</td><td>{$r['nombre']}</td><td>{$r['cantidad_gramos']}</td><td>{$r['fecha']}</td><td>{$r['unidad']}</td><td>{$r['precio']}</td></tr>";
}
?>
</table>

<!-- SALIDAS -->
<h2>Entregas a Cocina</h2>
<table>
<tr><th>ID</th><th>Alimento</th><th>Cantidad/Estudiante</th><th>#Estudiantes</th><th>Total</th><th>Unidad</th><th>Fecha</th></tr>
<?php
$res = $conexion->query("
    SELECT s.*, a.nombre 
    FROM salidas_alimentos s 
    JOIN alimentos a ON s.alimento_id = a.id 
    WHERE s.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'
");
while ($r = $res->fetch_assoc()) {
    echo "<tr><td>{$r['id']}</td><td>{$r['nombre']}</td><td>{$r['cantidad_por_estudiante']}</td><td>{$r['numero_estudiantes']}</td><td>{$r['cantidad_total']}</td><td>{$r['unidad']}</td><td>{$r['fecha']}</td></tr>";
}
?>
</table>

<!-- PRODUCTOS BIBLIOTECA -->
<h2>Productos Biblioteca</h2>
<table>
<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Cantidad</th><th>Fecha</th><th>Precio Unitario</th></tr>
<?php
$res = $conexion->query("SELECT * FROM productos_biblioteca");
while ($r = $res->fetch_assoc()) {
    echo "<tr><td>{$r['id']}</td><td>{$r['nombre']}</td><td>{$r['descripcion']}</td><td>{$r['cantidad']}</td><td>{$r['created_at']}</td><td>{$r['precio_unitario']}</td></tr>";
}
?>
</table>

<!-- PRESTAMOS -->
<h2>Préstamos</h2>
<table>
<tr><th>Producto</th><th>Alumno</th><th>Cantidad</th><th>Fecha Préstamo</th><th>Fecha Devolución</th></tr>
<?php
$res = $conexion->query("
    SELECT p.*, pb.nombre AS producto, a.nombre AS alumno
    FROM prestamos p
    JOIN productos_biblioteca pb ON p.producto_id = pb.id
    JOIN alumnos a ON p.alumno_id = a.id
    WHERE p.fecha_prestamo BETWEEN '$fecha_inicio' AND '$fecha_fin'
");

while ($r = $res->fetch_assoc()) {
    echo "<tr><td>{$r['producto']}</td><td>{$r['alumno']}</td><td>{$r['cantidad']}</td><td>{$r['fecha_prestamo']}</td><td>{$r['fecha_devolucion']}</td></tr>";

}
?>
</table>

<!-- VENTAS -->
<h2>Ventas Biblioteca</h2>
<table>
<tr><th>Producto</th><th>Cantidad</th><th>Cliente</th><th>Fecha</th><th>Total</th></tr>
<?php
$res = $conexion->query("
    SELECT v.*, pb.nombre AS producto 
    FROM ventas v 
    JOIN productos_biblioteca pb ON v.producto_id = pb.id 
    WHERE v.fecha_venta BETWEEN '$fecha_inicio' AND '$fecha_fin'
");
while ($r = $res->fetch_assoc()) {
    echo "<tr><td>{$r['producto']}</td><td>{$r['cantidad']}</td><td>{$r['cliente']}</td><td>{$r['fecha_venta']}</td><td>{$r['precio_total']}</td></tr>";
}
?>
</table>

<!-- BODEGA -->
<h2>Productos de Bodega</h2>
<table>
<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Cantidad</th><th>Fecha</th><th>Precio</th></tr>
<?php
$res = $conexion->query("SELECT * FROM productos_bodega");
while ($r = $res->fetch_assoc()) {
    echo "<tr><td>{$r['id']}</td><td>{$r['nombre']}</td><td>{$r['descripcion']}</td><td>{$r['cantidad']}</td><td>{$r['creado_en']}</td><td>{$r['precio']}</td></tr>";
}
?>
</table>

<?php
// CAPTURAR TODO EL HTML Y CARGAR EN DOMPDF
$html = ob_get_clean();

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("corte_mensual_" . date('Y_m') . ".pdf", ["Attachment" => false]);
?>

