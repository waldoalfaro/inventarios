<?php
include 'header.php';
include 'conexion.php';

// Productos con bajo stock en BODEGA
$sql_bodega = "SELECT COUNT(*) AS total_bodega FROM productos_bodega WHERE cantidad < 10";
$result_bodega = mysqli_query($conexion, $sql_bodega);
$total_bodega = mysqli_fetch_assoc($result_bodega)['total_bodega'];

// Productos con bajo stock en BIBLIOTECA
$sql_biblioteca = "SELECT COUNT(*) AS total_biblioteca FROM productos_biblioteca WHERE cantidad < 10";
$result_biblioteca = mysqli_query($conexion, $sql_biblioteca);
$total_biblioteca = mysqli_fetch_assoc($result_biblioteca)['total_biblioteca'];

$hoy = new DateTime();

// Último día del mes actual
$ultimoDiaMes = new DateTime();
$ultimoDiaMes->modify('last day of this month');

// Días restantes
$diasRestantes = $hoy->diff($ultimoDiaMes)->days;

// Nombres de los meses en español (evitando strftime)
$meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
$nombreMes = $meses[(int)$ultimoDiaMes->format('m') - 1];
$anio = $ultimoDiaMes->format('Y');
?>

<div class="container py-5">
    <div class="row">
        <!-- Columna izquierda: Imagen + Misión + Visión -->
        <div class="col-md-8">
            <!-- Imagen del Instituto -->
            <div class="text-center mb-4">
                <img src="img/inji.jpeg" alt="Imagen del Instituto" 
                     class="img-fluid mx-auto d-block rounded shadow"
                     style="max-width: 300px; height: auto;">
            </div>

            <!-- Misión y Visión -->
            <div class="row">
                <div class="col-md-6">
                    <h2 class="text-primary">Misión</h2>
                    <p class="text-muted">Nuestra misión es formar profesionales altamente capacitados en diversas áreas del conocimiento, fomentando la excelencia académica y los valores éticos.</p>
                </div>
                <div class="col-md-6">
                    <h2 class="text-primary">Visión</h2>
                    <p class="text-muted">Ser una institución líder en educación, reconocida por su calidad académica e innovación, contribuyendo al desarrollo de la sociedad.</p>
                </div>
            </div>
        </div>

        <!-- Columna derecha: Tarjetas de productos con bajo stock -->
        <div class="col-md-4 d-flex flex-column justify-content-center gap-4">
            <!-- Tarjeta de productos_bodega -->
            <div class="card text-white bg-danger shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">Productos en Bodega</h5>
                    <p class="display-5"><?= $total_bodega ?></p>
                    <p class="card-text">Productos con menos de 10 unidades.</p>
                </div>
            </div>

            <!-- Tarjeta de productos_bibliotecas -->
            <div class="card text-white bg-warning shadow">
                <div class="card-body text-center">
                    <h5 class="card-title">Productos en Biblioteca</h5>
                    <p class="display-5"><?= $total_biblioteca ?></p>
                    <p class="card-text">Productos con menos de 10 unidades.</p>
                </div>
            </div>

            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="bi bi-calendar2-week-fill me-2"></i>
                <div>
                    🗓️ Faltan <strong><?php echo $diasRestantes; ?> día<?php echo $diasRestantes != 1 ? 's' : ''; ?></strong> para el corte mensual de <strong><?php echo $nombreMes . ' ' . $anio; ?></strong>.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

