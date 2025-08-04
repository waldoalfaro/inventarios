<?php
require '../vendor/autoload.php';
use Dompdf\Dompdf;
include '../conexion.php';

$html = '<h2 style="text-align:center;"> Reporte de Stock Actual</h2>';
$html .= '<table border="1" cellspacing="0" cellpadding="5" width="100%">
            <tr>
                <th>Alimento</th>
                <th>Descripción</th>
                <th>Stock (g)</th>
                <th>Fecha de Registro</th>
            </tr>';

$resultado = mysqli_query($conexion, "SELECT * FROM alimentos");
while ($r = mysqli_fetch_assoc($resultado)) {
    $html .= "<tr>
                <td>{$r['nombre']}</td>
                <td>{$r['descripcion']}</td>
                <td>{$r['stock_gramos']} g</td>
                <td>{$r['creado_en']}</td>
              </tr>";
}
$html .= '</table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("reporte_stock.pdf", ["Attachment" => true]);
exit;
