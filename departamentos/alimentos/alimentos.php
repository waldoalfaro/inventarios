<?php
include '../../header.php';
include '../../conexion.php';

// Manejo de formularios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Registrar entrada
    if (isset($_POST['registro_entrada'])) {
        $alimento_id = $_POST['alimento_id'];
        $cantidad = floatval($_POST['cantidad']);
        $unidad = $_POST['unidad'];
        $fecha = $_POST['fecha'];
        $precio = isset($_POST['precio']) && $_POST['precio'] !== '' ? floatval($_POST['precio']) : null;

        // Convertir a gramos
        switch ($unidad) {
            case 'kilogramos':
                $cantidad *= 1000;
                break;
            case 'libras':
                $cantidad *= 453.592;
                break;
        }

        mysqli_query($conexion, "INSERT INTO entradas_alimentos (alimento_id, cantidad_gramos, unidad, precio, fecha)
                                 VALUES ('$alimento_id', '$cantidad', '$unidad', " . ($precio !== null ? "'$precio'" : "NULL") . ", '$fecha')");

        mysqli_query($conexion, "UPDATE alimentos SET stock_gramos = stock_gramos + $cantidad WHERE id = $alimento_id");
    }

    // Registrar salida
    if (isset($_POST['registro_salida'])) {
        $alimento_id = $_POST['salida_alimento_id'];
        $por_estudiante = floatval($_POST['cantidad_por_estudiante']);
        $unidad_salida = $_POST['unidad_salida'];
        $estudiantes = intval($_POST['numero_estudiantes']);
        $fecha = $_POST['fecha_salida'];

        // Convertir a gramos
        switch ($unidad_salida) {
            case 'kilogramos':
                $por_estudiante *= 1000;
                break;
            case 'libras':
                $por_estudiante *= 453.592;
                break;
        }

        $total = $por_estudiante * $estudiantes;

        // Verificar stock
        $res = mysqli_query($conexion, "SELECT stock_gramos FROM alimentos WHERE id = $alimento_id");
        $fila = mysqli_fetch_assoc($res);

        if ($fila['stock_gramos'] >= $total) {
            mysqli_query($conexion, "INSERT INTO salidas_alimentos (alimento_id, cantidad_por_estudiante, unidad, numero_estudiantes, cantidad_total, fecha)
                                     VALUES ('$alimento_id', '$por_estudiante', '$unidad_salida', '$estudiantes', '$total', '$fecha')");

            mysqli_query($conexion, "UPDATE alimentos SET stock_gramos = stock_gramos - $total WHERE id = $alimento_id");

            echo "<div class='alert alert-success'>✅ Entrega registrada correctamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>❌ No hay suficiente stock para esta entrega. Stock actual: {$fila['stock_gramos']}g</div>";
        }
    }
}

function paginar($total, $pagina_actual, $limite, $parametro) {
    $total_paginas = ceil($total / $limite);
    echo "<nav><ul class='pagination justify-content-center'>";
    for ($i = 1; $i <= $total_paginas; $i++) {
        $active = $i == $pagina_actual ? 'active' : '';
        echo "<li class='page-item $active'><a class='page-link' href='?{$parametro}={$i}#{$parametro}'>{$i}</a></li>";
    }
    echo "</ul></nav>";
}
?>

<div class="container py-4">
    <a href="nuevo_alimento.php" class="btn btn-primary mb-3">➕ Agregar Nuevo Alimento</a>
    <h2 class="text-center text-success mb-4">Control de Alimentos</h2>
    <div class="row">
        <!-- Entradas -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">Registrar Entrada</div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="registro_entrada">
                        <div class="mb-2">
                            <label>Alimento</label>
                            <select name="alimento_id" class="form-control" required>
                                <?php
                                $alimentos = mysqli_query($conexion, "SELECT * FROM alimentos");
                                while ($a = mysqli_fetch_assoc($alimentos)) {
                                    echo "<option value='{$a['id']}'>{$a['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Cantidad</label>
                            <input type="number" step="0.01" name="cantidad" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Unidad</label>
                            <select name="unidad" class="form-control" required>
                                <option value="gramos">Gramos</option>
                                <option value="kilogramos">Kilogramos</option>
                                <option value="libras">Libras</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Precio Total</label>
                            <input type="number" step="0.01" name="precio" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Fecha</label>
                            <input type="date" name="fecha" class="form-control" required>
                        </div>
                        <button class="btn btn-success w-100">Guardar Entrada</button>
                    </form>
                </div>
            </div>
        </div>


        



        <!-- Salidas -->
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header bg-warning text-dark">Registrar Entrega a Cocina</div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="registro_salida">
                        <div class="mb-2">
                            <label>Alimento</label>
                            <select name="salida_alimento_id" class="form-control" required>
                                <?php
                                $alimentos2 = mysqli_query($conexion, "SELECT * FROM alimentos");
                                while ($a = mysqli_fetch_assoc($alimentos2)) {
                                    echo "<option value='{$a['id']}'>{$a['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Cantidad por estudiante</label>
                            <input type="number" step="0.01" name="cantidad_por_estudiante" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Unidad</label>
                            <select name="unidad_salida" class="form-control" required>
                                <option value="gramos">Gramos</option>
                                <option value="kilogramos">Kilogramos</option>
                                <option value="libras">Libras</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label>Número de estudiantes</label>
                            <input type="number" name="numero_estudiantes" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label>Fecha</label>
                            <input type="date" name="fecha_salida" class="form-control" required>
                        </div>
                        <button class="btn btn-warning w-100">Guardar Salida</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    
    <!-- Stock actual -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-info text-white">Stock Actual de Alimentos</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Alimento</th>
                        <th>Descripción</th>
                        <th>Stock (gramos)</th>
                        <th>Fecha de ingreso</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pagina_stock = isset($_GET['stock']) ? (int)$_GET['stock'] : 1;
                    $limite_stock = 5;
                    $offset_stock = ($pagina_stock - 1) * $limite_stock;

                    $total_stock = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) AS total FROM alimentos"))['total'];
                    $stock = mysqli_query($conexion, "SELECT * FROM alimentos LIMIT $offset_stock, $limite_stock");

                    while ($r = mysqli_fetch_assoc($stock)) {
                        echo "<tr>
                                <td>{$r['nombre']}</td>
                                <td>{$r['descripcion']}</td>
                                <td>{$r['stock_gramos']} g</td>
                                <td>{$r['creado_en']}</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php paginar($total_stock, $pagina_stock, $limite_stock, 'stock'); ?>

        </div>
    </div>

    <!-- Historial de entregas -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-secondary text-white">Historial de Entregas a Cocina</div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Alimento</th>
                        <th>Cantidad/Estudiante</th>
                        <th>Unidad</th>
                        <th># Estudiantes</th>
                        <th>Total Entregado (g)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pagina_salidas = isset($_GET['salidas']) ? (int)$_GET['salidas'] : 1;
                    $limite_salidas = 5;
                    $offset_salidas = ($pagina_salidas - 1) * $limite_salidas;

                    $total_salidas = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) AS total FROM salidas_alimentos"))['total'];
                    $salidas = mysqli_query($conexion, "
                        SELECT s.*, a.nombre AS alimento 
                        FROM salidas_alimentos s
                        INNER JOIN alimentos a ON s.alimento_id = a.id
                        ORDER BY s.fecha DESC
                        LIMIT $offset_salidas, $limite_salidas
                    ");

                    while ($s = mysqli_fetch_assoc($salidas)) {
                        echo "<tr>
                                <td>{$s['fecha']}</td>
                                <td>{$s['alimento']}</td>
                                <td>{$s['cantidad_por_estudiante']}</td>
                                <td>{$s['unidad']}</td>
                                <td>{$s['numero_estudiantes']}</td>
                                <td>{$s['cantidad_total']} g</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
            <?php paginar($total_salidas, $pagina_salidas, $limite_salidas, 'salidas'); ?>

        </div>

        
    </div>
<!-- Historial de Entradas de Alimentos -->
<div class="card shadow-sm mt-4">
    <div class="card-header bg-success text-white">Historial de Compras de Alimentos</div>
    <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Fecha</th>
                    <th>Alimento</th>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    <th>Precio Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pagina_entradas = isset($_GET['entradas']) ? (int)$_GET['entradas'] : 1;
                $limite_entradas = 5;
                $offset_entradas = ($pagina_entradas - 1) * $limite_entradas;

                $total_entradas = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) AS total FROM entradas_alimentos"))['total'];
                $entradas = mysqli_query($conexion, "
                    SELECT e.*, a.nombre AS alimento 
                    FROM entradas_alimentos e
                    INNER JOIN alimentos a ON e.alimento_id = a.id
                    ORDER BY e.fecha DESC
                    LIMIT $offset_entradas, $limite_entradas
                ");


                while ($e = mysqli_fetch_assoc($entradas)) {
                    echo "<tr>
                            <td>{$e['fecha']}</td>
                            <td>{$e['alimento']}</td>
                            <td>{$e['cantidad_gramos']}</td>
                            <td>{$e['unidad']}</td>
                            <td> {$e['precio']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
        <?php paginar($total_entradas, $pagina_entradas, $limite_entradas, 'entradas'); ?>

    </div>
</div>

    
</div>




<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>





