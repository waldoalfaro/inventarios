<?php
require '../vendor/autoload.php';
require '../conexion.php';
use Dompdf\Dompdf;
use Dompdf\Options;


// Obtener préstamos
$sql = "SELECT pr.id, p.nombre AS producto, a.nombre AS alumno, pr.cantidad, pr.fecha_prestamo, pr.fecha_devolucion
        FROM prestamos pr
        INNER JOIN productos_biblioteca p ON pr.producto_id = p.id
        INNER JOIN alumnos a ON pr.alumno_id = a.id
        ORDER BY pr.fecha_prestamo DESC";

$result = $conexion->query($sql);

$html = '<h1 style="text-align:center;">Reporte de Préstamos - Biblioteca</h1>';
$html .= '<table border="1" cellpadding="5" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Alumno</th>
                    <th>Cantidad</th>
                    <th>Fecha Préstamo</th>
                    <th>Fecha Devolución</th>
                </tr>
            </thead><tbody>';

while ($row = $result->fetch_assoc()) {
    $html .= '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['producto'] . '</td>
                <td>' . $row['alumno'] . '</td>
                <td>' . $row['cantidad'] . '</td>
                <td>' . $row['fecha_prestamo'] . '</td>
                <td>' . ($row['fecha_devolucion'] ?? 'Pendiente') . '</td>
              </tr>';
}

$html .= '</tbody></table>';

$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("reporte_prestamos_biblioteca.pdf", ["Attachment" => false]);
?>
