<?php
require '../vendor/autoload.php';
require '../conexion.php';

use Dompdf\Dompdf;
use Dompdf\Options;


// Obtener ventas
$sql = "SELECT v.id, p.nombre AS producto, v.cantidad, v.precio_total, v.fecha_venta, v.cliente 
        FROM ventas v 
        INNER JOIN productos_biblioteca p ON v.producto_id = p.id 
        ORDER BY v.fecha_venta DESC";

$result = $conexion->query($sql);

$html = '<h1 style="text-align:center;">Reporte de Ventas - Biblioteca</h1>';
$html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Total</th>
                    <th>Cliente</th>
                    <th>Fecha de Venta</th>
                </tr>
            </thead><tbody>';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['producto'] . '</td>
                <td>' . $row['cantidad'] . '</td>
                <td>$' . number_format($row['precio_total'], 2) . '</td>
                <td>' . $row['cliente'] . '</td>
                <td>' . $row['fecha_venta'] . '</td>
              </tr>';
}

$html .= '</tbody></table>';

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("reporte_ventas_biblioteca.pdf", ["Attachment" => false]);
?>
