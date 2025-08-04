<?php
include '../../header.php';

$sql = "SELECT * FROM productos_bodega";
$result = mysqli_query($conexion, $sql);
?> 

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bodega - Inventario</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="d-flex">
  <!-- Sidebar -->
  <div class="sidebar p-3" style="width: 250px; min-height: 100vh;">
    <h5>Opciones</h5>
    <a class="d-block mb-2" href="?vista=productos">Gestión de productos</a>
    <a class="d-block mb-2" href="?vista=registro">Registrar producto</a>
    <a class="d-block mb-2" href="?vista=movimientos">Historial de movimientos</a>

  </div>

  

  <!-- Contenido principal -->
  <div class="main-content flex-grow-1 p-4">
    <?php
    $vista = $_GET['vista'] ?? 'inicio';

    if ($vista === 'registro') {

    ?>
      <h2>Registrar Nuevo Producto</h2>
      <form action="guardar_producto.php" method="POST" class="mt-4">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre del producto</label>
          <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="descripcion" class="form-label">Descripción</label>
          <input type="text" name="descripcion" id="descripcion" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="cantidad" class="form-label">Cantidad inicial</label>
          <input type="number" name="cantidad" id="cantidad" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="precio" class="form-label">Precio</label>
          <input type="number" step="0.01" name="precio" id="precio" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar producto</button>
      </form>

    <?php
    } elseif ($vista === 'productos') {

      // Paginación
            $productosPorPagina = 2;
            $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $inicio = ($pagina - 1) * $productosPorPagina;

            // Total de productos
            $totalProductosQuery = "SELECT COUNT(*) AS total FROM productos_bodega";
            $totalProductosResult = mysqli_query($conexion, $totalProductosQuery);
            $totalProductos = mysqli_fetch_assoc($totalProductosResult)['total'];
            $totalPaginas = ceil($totalProductos / $productosPorPagina);

            // Obtener productos con LIMIT
            $sql = "SELECT * FROM productos_bodega LIMIT $inicio, $productosPorPagina";
            $result = mysqli_query($conexion, $sql);


    ?>
      <h2>Inventario de Bodega</h2>
      <table class="table table-bordered table-hover mt-4">
      <thead class="table-primary">
    <tr>
      <th>Nombre del producto</th>
      <th>Descripción</th>
      <th>Cantidad actual</th>
      <th>Precio U</th>
      <th>Fecha de registro</th>
      <th>Movimiento</th>
      <th>Acción</th>
    </tr>
  </thead>
  <tbody>
<?php
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    // Umbral de stock bajo
    $stock_bajo = $row['cantidad'] <= 9;
    $clase = $stock_bajo ? 'table-danger' : '';

    echo "<tr class='$clase'>";
    echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
    echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
    echo "<td>" . htmlspecialchars($row['cantidad']) . "</td>";
    echo "<td>$" . number_format($row['precio'], 2) . "</td>";
    echo "<td>" . date('d/m/Y H:i', strtotime($row['creado_en'])) . "</td>";
    ?>
    <form action="actualizar_producto.php" method="POST">
      <td>
        <input type="number" class="form-control mb-2" name="cantidad_movimiento" placeholder="Cantidad" required>
        <select name="tipo_movimiento" class="form-select mb-2" required>
          <option value="entrada">Entrada</option>
          <option value="salida">Salida</option>
        </select>
        <input type="hidden" name="id_producto" value="<?php echo $row['id']; ?>">
      </td>
      <td>
        <button class="btn btn-success" type="submit">Guardar</button>
        <a href="Eliminar_producto.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
      </td>
    </form>
    <?php
    echo "</tr>";
  }
} else {
  echo "<tr><td colspan='7'>No hay productos disponibles</td></tr>";
}
?>
</tbody>

</table>

<!-- Paginación -->
<nav>
  <ul class="pagination">
    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
      <li class="page-item <?= ($i == $pagina) ? 'active' : '' ?>">
        <a class="page-link" href="?vista=productos&pagina=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>
  </ul>
</nav>


            <?php
            }elseif($vista === 'movimientos') {

              include 'historial_movimientos.php';

            } else {
            // Vista por defecto (inicio)
            ?>
            <h2>Bienvenido al área de Bodega</h2>
            <p>Utiliza el menú lateral para gestionar o registrar productos.</p>
            <?php } ?>
  </div>

  
</div>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
