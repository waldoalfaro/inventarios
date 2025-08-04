<?php
include '../../conexion.php';


// Paginación
$movimientosPorPagina = 2;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $movimientosPorPagina;

// Total de movimientos
$totalMovimientosQuery = "SELECT COUNT(*) AS total FROM movimientos_bodega";
$totalMovimientosResult = mysqli_query($conexion, $totalMovimientosQuery);
$totalMovimientos = mysqli_fetch_assoc($totalMovimientosResult)['total'];
$totalPaginas = ceil($totalMovimientos / $movimientosPorPagina);

// Consulta paginada
$sql = "SELECT m.*, p.nombre 
        FROM movimientos_bodega m 
        JOIN productos_bodega p ON m.producto_id = p.id 
        ORDER BY m.fecha DESC 
        LIMIT $inicio, $movimientosPorPagina";
$result = mysqli_query($conexion, $sql);


?>

<h2>Historial de Movimientos</h2>
<table class="table table-bordered table-hover mt-4">
  <thead class="table-info">
    <tr>
      <th>Producto</th>
      <th>Tipo</th>
      <th>Cantidad</th>
      <th>Fecha</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?= htmlspecialchars($row['nombre']) ?></td>
        <td><?= ucfirst($row['tipo']) ?></td>
        <td><?= $row['cantidad'] ?></td>
        <td><?= date('d/m/Y H:i', strtotime($row['fecha'])) ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>


<!-- Paginación -->
<nav>
  <ul class="pagination">
    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
      <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
        <a class="page-link" href="?vista=movimientos&pagina=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>
