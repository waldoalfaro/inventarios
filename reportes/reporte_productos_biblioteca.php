<?php
require '../vendor/autoload.php';
require '../conexion.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Obtener productos
$sql = "SELECT id, nombre, descripcion, cantidad, created_at, precio_unitario FROM productos_biblioteca ORDER BY nombre ASC";
$result = $conexion->query($sql);

$html = '<h1 style="text-align:center;">Reporte de Productos - Biblioteca</h1>';
$html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead><tbody>';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['nombre'] . '</td>
                <td>' . $row['descripcion'] . '</td>
                <td>' . $row['cantidad'] . '</td>
                <td>$' . number_format($row['precio_unitario'], 2) . '</td>
                <td>' . $row['created_at'] . '</td>
              </tr>';
}

$html .= '</tbody></table>';

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("reporte_productos_biblioteca.pdf", ["Attachment" => false]);
?>
