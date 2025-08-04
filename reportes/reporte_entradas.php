<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;
include '../conexion.php';

$html = '<h2 style="text-align:center;">Reporte de Entradas de Alimentos</h2>';
$html .= '<table border="1" cellspacing="0" cellpadding="5" width="100%">
            <tr>
                <th>Fecha</th>
                <th>Alimento</th>
                <th>Cantidad (g)</th>
                <th>Unidad</th>
                <th>Precio</th>
            </tr>';

$datos = mysqli_query($conexion, "
    SELECT e.*, a.nombre AS alimento
    FROM entradas_alimentos e
    INNER JOIN alimentos a ON e.alimento_id = a.id
    ORDER BY e.fecha DESC
");

while ($e = mysqli_fetch_assoc($datos)) {
    $html .= "<tr>
                <td>{$e['fecha']}</td>
                <td>{$e['alimento']}</td>
                <td>{$e['cantidad_gramos']}</td>
                <td>{$e['unidad']}</td>
                <td>{$e['precio']}</td>
              </tr>";
}
$html .= '</table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("reporte_entradas.pdf", ["Attachment" => true]);
exit;
