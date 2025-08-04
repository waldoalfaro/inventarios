<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;
include '../conexion.php';

$html = '<h2 style="text-align:center;">Reporte de Entregas a Cocina</h2>';
$html .= '<table border="1" cellspacing="0" cellpadding="5" width="100%">
            <tr>
                <th>Fecha</th>
                <th>Alimento</th>
                <th>Cantidad/Estudiante</th>
                <th>Unidad</th>
                <th># Estudiantes</th>
                <th>Total Entregado (g)</th>
            </tr>';

$datos = mysqli_query($conexion, "
    SELECT s.*, a.nombre AS alimento 
    FROM salidas_alimentos s
    INNER JOIN alimentos a ON s.alimento_id = a.id
    ORDER BY s.fecha DESC
");

while ($s = mysqli_fetch_assoc($datos)) {
    $html .= "<tr>
                <td>{$s['fecha']}</td>
                <td>{$s['alimento']}</td>
                <td>{$s['cantidad_por_estudiante']}</td>
                <td>{$s['unidad']}</td>
                <td>{$s['numero_estudiantes']}</td>
                <td>{$s['cantidad_total']} g</td>
              </tr>";
}
$html .= '</table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("reporte_salidas.pdf", ["Attachment" => true]);
exit;
