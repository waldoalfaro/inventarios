<?php
include '../../header.php';
include '../../conexion.php'; // Asegúrate que este archivo tenga tu conexión a la BD

// Cargar productos y alumnos
$sql_productos = "SELECT * FROM productos_biblioteca";
$productos_result = mysqli_query($conexion, $sql_productos);

$sql_alumnos = "SELECT * FROM alumnos";
$alumnos_result = mysqli_query($conexion, $sql_alumnos);




$_SESSION['tipo_usuario'] = 'administrador'; // o 'vendedor', etc.

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
    <a class="d-block mb-2" href="?vista=productos">Productos</a>
    <a class="d-block mb-2" href="?vista=registro">Registrar producto</a>
    <a class="d-block mb-2" href="?vista=prestamos">Préstamos</a>
    <a class="d-block mb-2" href="?vista=ventas">Ventas</a>
    <a class="d-block mb-2" href="?vista=alumnos">Alumnos</a>
    <a class="d-block mb-2" href="?vista=lista_prestamos">Lista de Préstamos</a>
    <a class="d-block mb-2" href="?vista=lista_ventas">Lista de Ventas</a>
    <a href="biblioteca.php?vista=movimientos">Movimientos</a>

  </div>

  <!-- Contenido principal -->
  <div class="main-content flex-grow-1 p-4">
    <?php
    $vista = $_GET['vista'] ?? 'inicio';

    // Registrar nuevo producto
    if ($vista === 'registro') {
?>
  <h2>Registrar Nuevo Producto</h2>
  <form action="guardar_producto.php" method="POST" class="mt-4">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre del producto</label>
      <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <input type="text" name="descripcion" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="cantidad" class="form-label">Cantidad inicial</label>
      <input type="number" name="cantidad" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="precio_unitario" class="form-label">Precio unitario</label>
      <input type="number" name="precio_unitario" class="form-control" step="0.01" min="0" required>
    </div>
    <button type="submit" class="btn btn-primary">Guardar producto</button>
  </form>

<?php
// Mostrar productos
} elseif ($vista === 'productos') {
?>
  <h2>Inventario de Biblioteca</h2>
  <table class="table table-bordered table-hover mt-4">
    <thead class="table-primary">
      <tr>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Movimiento</th>
        <th>Acción</th>
      </tr>
    </thead>
    <tbody>
  <?php while ($row = mysqli_fetch_assoc($productos_result)): ?>
    <?php
      // Umbral para considerar stock bajo
      $stock_bajo = $row['cantidad'] <= 9;
      $clase_fila = $stock_bajo ? 'table-danger' : '';
    ?>
    <tr class="<?= $clase_fila ?>">
      <td><?= htmlspecialchars($row['nombre'] ?? '') ?></td>
      <td><?= htmlspecialchars($row['descripcion'] ?? '') ?></td>
      <td><?= $row['cantidad'] ?></td>
      <td>$<?= number_format($row['precio_unitario'], 2) ?></td>

      <!-- Formulario dentro de la fila -->
      <form action="actualizar_producto.php" method="POST">
        <td>
          <div class="input-group">
            <input type="number" class="form-control" name="cantidad_movimiento" placeholder="Cantidad" required>
            <select name="tipo_movimiento" class="form-select" required>
              <option value="" disabled selected>Tipo</option>
              <option value="entrada">Entrada</option>
              <option value="salida">Salida</option>
            </select>
          </div>
          <input type="hidden" name="id_producto" value="<?= $row['id'] ?>">
        </td>
        <td>
          <button class="btn btn-success btn-sm" type="submit">Guardar</button>
          <a href="eliminar_producto.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
        </td>
      </form>
    </tr>
  <?php endwhile; ?>
</tbody>

  </table>
    <?php
    // Préstamos
    } elseif ($vista === 'prestamos') {
?>
  <h2>Registrar Préstamo</h2>
  <form action="guardar_prestamo.php" method="POST" class="mt-4">
    <!-- Alumno -->
    <!-- Alumno -->
<div class="mb-3">
  <label for="alumno_nombre" class="form-label">Carnet o Nombre del Alumno</label>
  <input list="lista_alumnos" name="alumno_nombre" id="alumno_nombre" class="form-control" placeholder="Buscar alumno" required>
  <datalist id="lista_alumnos">
    <?php mysqli_data_seek($alumnos_result, 0); while ($alumno = mysqli_fetch_assoc($alumnos_result)): ?>
      <option value="<?= $alumno['carnet'] ?> - <?= $alumno['nombre'] ?>"></option>
    <?php endwhile; ?>
  </datalist>
</div>

<!-- Producto -->
<div class="mb-3">
  <label for="producto_nombre" class="form-label">Nombre del Producto</label>
  <input list="lista_productos" name="producto_nombre" id="producto_nombre" class="form-control" placeholder="Buscar producto" required>
  <datalist id="lista_productos">
    <?php mysqli_data_seek($productos_result, 0); while ($producto = mysqli_fetch_assoc($productos_result)): ?>
      <option value="<?= $producto['nombre'] ?>" data-stock="<?= $producto['cantidad'] ?>"></option>
    <?php endwhile; ?>
  </datalist>
</div>


    <!-- Cantidad -->
    <div class="mb-3">
      <label for="cantidad" class="form-label">Cantidad a prestar</label>
      <input type="number" name="cantidad" class="form-control" required>
    </div>

    <!-- Fecha de préstamo (automática) -->
    <!-- Fecha de préstamo -->
<div class="mb-3">
  <label for="fecha_prestamo" class="form-label">Fecha de préstamo</label>
  <input type="date" name="fecha_prestamo" class="form-control" value="<?= date('Y-m-d') ?>" required>
</div>

<!-- Fecha de entrega -->
<div class="mb-3">
  <label for="fecha_entrega" class="form-label">Fecha de entrega</label>
  <input type="date" name="fecha_devolucion" class="form-control" required>
</div>


    <button type="submit" class="btn btn-primary">Guardar Préstamo</button>
  </form>

  <script>
    function searchAlumno() {
      const searchValue = document.getElementById('alumno_search').value.toLowerCase();
      const options = document.querySelectorAll('#alumno_select option');

      options.forEach(option => {
        const text = option.textContent.toLowerCase();
        option.style.display = text.includes(searchValue) ? 'block' : 'none';
      });
    }

    function searchProducto() {
      const searchValue = document.getElementById('producto_search').value.toLowerCase();
      const options = document.querySelectorAll('#producto_select option');

      options.forEach(option => {
        const text = option.textContent.toLowerCase();
        option.style.display = searchValue.length >= 3 && text.includes(searchValue) ? 'block' : 'none';
      });
    }

    document.addEventListener('DOMContentLoaded', function () {
    const productoInput = document.getElementById('producto_nombre');
    const cantidadInput = document.querySelector('input[name="cantidad"]');

    // Escucha cuando el producto cambia
    productoInput.addEventListener('change', function () {
      const productoSeleccionado = this.value;
      const opciones = document.querySelectorAll('#lista_productos option');
      opciones.forEach(option => {
        if (option.value === productoSeleccionado) {
          productoInput.dataset.stock = option.dataset.stock;
        }
      });
    });

    // Verifica el stock cuando el usuario escribe la cantidad
    cantidadInput.addEventListener('input', function () {
      const stockDisponible = parseInt(productoInput.dataset.stock) || 0;
      const cantidadDeseada = parseInt(this.value) || 0;

      if (cantidadDeseada > stockDisponible) {
        alert("No puedes prestar más productos de los disponibles en inventario (" + stockDisponible + ").");
        this.value = stockDisponible;
      }
    });
  });
  </script>


    <?php
    // Ventas
    } elseif ($vista === 'ventas') {
    ?>
      <h2>Registrar Venta</h2>
<form action="guardar_venta.php" method="POST" class="mt-4">
  <!-- Producto -->
  <div class="mb-3">
    <label for="producto_id" class="form-label">Producto</label>
    <select name="producto_id" id="producto_id" class="form-select" onchange="actualizarPrecio()" required>
      <option value="" disabled selected>Seleccione un producto</option>
      <?php
      mysqli_data_seek($productos_result, 0);
      while ($producto = mysqli_fetch_assoc($productos_result)):
      ?>
        <option value="<?= $producto['id'] ?>" 
          data-precio="<?= $producto['precio_unitario'] ?>" 
          data-stock="<?= $producto['cantidad'] ?>">
          <?= $producto['nombre'] ?>
        </option>
      <?php endwhile; ?>
    </select>
  </div>

  <!-- Cantidad -->
  <div class="mb-3">
    <label for="cantidad" class="form-label">Cantidad vendida</label>
    <input type="number" name="cantidad" id="cantidad" class="form-control" oninput="calcularTotal()" required>
  </div>

  <!-- Cliente o persona -->
  <div class="mb-3">
    <label for="cliente" class="form-label">Persona que se llevó el producto</label>
    <input type="text" name="cliente" class="form-control" placeholder="Nombre del cliente" required>
  </div>

  <!-- Precio total -->
  <div class="mb-3">
    <label for="precio_total" class="form-label">Precio total</label>
    <input type="text" name="precio_total" id="precio_total" class="form-control" readonly>
  </div>

  <button type="submit" class="btn btn-success">Registrar Venta</button>
</form>

<script>
  function actualizarPrecio() {
    calcularTotal();
  }

  function calcularTotal() {
    const productoSelect = document.getElementById('producto_id');
    const cantidadInput = document.getElementById('cantidad');
    const precioTotal = document.getElementById('precio_total');

    const selectedOption = productoSelect.options[productoSelect.selectedIndex];
    const stock = parseInt(selectedOption?.getAttribute('data-stock')) || 0;
    const precioUnitario = parseFloat(selectedOption?.getAttribute('data-precio')) || 0;
    const cantidad = parseInt(cantidadInput.value) || 0;

    if (cantidad > stock) {
      alert("No puedes vender más productos de los que hay en inventario (" + stock + ")");
      cantidadInput.value = stock;
      return;
    }

    const total = (cantidad * precioUnitario).toFixed(2);
    precioTotal.value = total;
  }
</script>



    <?php
    // Alumnos
    } elseif ($vista === 'alumnos') {
    ?>
      <h2>Listado de Alumnos</h2>
      <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalRegistroAlumno">
        Registrar nuevo alumno
      </button>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Carnet</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php mysqli_data_seek($alumnos_result, 0); while ($alumno = mysqli_fetch_assoc($alumnos_result)): ?>
            <tr>
              <td><?= htmlspecialchars($alumno['nombre']) ?></td>
              <td><?= htmlspecialchars($alumno['carnet'] ?? '') ?></td>
              <td>
                <a href="eliminar_alumno.php?id=<?= $alumno['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>

      <!-- Modal para registrar alumno -->
      <div class="modal fade" id="modalRegistroAlumno" tabindex="-1" aria-labelledby="modalRegistroAlumnoLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="guardar_alumno.php" method="POST">
              <div class="modal-header">
                <h5 class="modal-title" id="modalRegistroAlumnoLabel">Registrar Alumno</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label for="nombre" class="form-label">Nombre del Alumno</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                  <label for="carnet" class="form-label">Carnet del Alumno</label>
                  <input type="text" class="form-control" id="carnet" name="carnet" required>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-success">Guardar Alumno</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <?php
          } elseif ($vista === 'lista_prestamos') {
    $query = "SELECT p.id, a.nombre AS alumno, pr.nombre AS producto, p.cantidad, p.fecha_prestamo, p.fecha_devolucion
              FROM prestamos p
              INNER JOIN alumnos a ON p.alumno_id = a.id
              INNER JOIN productos_biblioteca pr ON p.producto_id = pr.id
              ORDER BY p.fecha_prestamo DESC";
    $prestamos_result = mysqli_query($conexion, $query);
  ?>
    <h2>Lista de Préstamos</h2>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Alumno</th>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Fecha del Préstamo</th>
          <th>Fecha de Devolución</th> <!-- NUEVA COLUMNA -->
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($prestamos_result)): ?>
          <tr>
            <td><?= htmlspecialchars($row['alumno']) ?></td>
            <td><?= htmlspecialchars($row['producto']) ?></td>
            <td><?= $row['cantidad'] ?></td>
            <td><?= $row['fecha_prestamo'] ?></td>
            <td><?= $row['fecha_devolucion'] ?></td> <!-- NUEVO DATO -->
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
      <?php

     } elseif ($vista === 'lista_ventas') {
  $query = "SELECT v.id, pr.nombre AS producto, v.cantidad, v.cliente, v.precio_total, v.fecha_venta
            FROM ventas v
            INNER JOIN productos_biblioteca pr ON v.producto_id = pr.id
            ORDER BY v.fecha_venta DESC";
  $ventas_result = mysqli_query($conexion, $query);
?>
  <h2>Lista de Ventas</h2>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Persona</th>
        <th>Total</th>
        <th>Fecha</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($ventas_result)): ?>
        <tr>
          <td><?= htmlspecialchars($row['producto']) ?></td>
          <td><?= $row['cantidad'] ?></td>
          <td><?= htmlspecialchars($row['cliente']) ?></td>
          <td>$<?= number_format($row['precio_total'], 2) ?></td>
          <td><?= $row['fecha_venta'] ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>

    <?php
    // Bienvenida
    } elseif ($vista === 'movimientos') {
    // Consulta movimientos con JOIN para mostrar el nombre del producto
    $sql_mov = "SELECT m.*, p.nombre AS nombre_producto 
                FROM movimientos_biblioteca m
                INNER JOIN productos_biblioteca p ON m.producto_id = p.id
                ORDER BY m.fecha DESC";

    $movimientos_result = mysqli_query($conexion, $sql_mov);
?>
  <h2>Movimientos de Inventario (Biblioteca)</h2>

<table class="table table-bordered table-hover mt-4">
  <thead class="table-info">
    <tr>
      <th>Producto</th>
      <th>Tipo de Movimiento</th>
      <th>Cantidad</th>
      <th>Fecha</th>
      <?php if ($_SESSION['tipo_usuario'] === 'administrador'): ?>
        <th>Acción</th>
      <?php endif; ?>
    </tr>
  </thead>
  <tbody>
    <?php while ($mov = mysqli_fetch_assoc($movimientos_result)): ?>
      <tr>
        <td><?= htmlspecialchars($mov['nombre_producto'] ?? '') ?></td>
        <td>
          <span class="badge bg-<?= $mov['tipo'] === 'entrada' ? 'success' : 'danger' ?>">
            <?= ucfirst($mov['tipo']) ?>
          </span>
        </td>
        <td><?= $mov['cantidad'] ?></td>
        <td><?= date('d/m/Y H:i', strtotime($mov['fecha'])) ?></td>
        <?php if ($_SESSION['tipo_usuario'] === 'admin'): ?>
          <td>
            <a href="editar_movimiento.php?id=<?= $mov['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
          </td>
        <?php endif; ?>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php
}else {
    ?>
      <h2>Bienvenido al área de Biblioteca</h2>
      <p>Utiliza el menú lateral para gestionar productos, préstamos, ventas o alumnos.</p>
    <?php } ?>
  </div>
</div>

<?php
mysqli_close($conexion);
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
