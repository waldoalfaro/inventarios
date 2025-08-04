<?php
include '../../header.php';
include '../../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);

    if (!empty($nombre)) {
        mysqli_query($conexion, "INSERT INTO alimentos (nombre, descripcion) VALUES ('$nombre', '$descripcion')");
        header("Location: alimentos.php");
        exit;
    }
}
?>

<div class="container py-4">
    <h2 class="text-center mb-4">Registrar Nuevo Alimento</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label>Nombre del alimento</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Descripción (opcional)</label>
                    <textarea name="descripcion" class="form-control" rows="3"></textarea>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="alimentos.php" class="btn btn-secondary">⬅ Volver</a>
                    <button class="btn btn-success">Guardar Alimento</button>
                </div>
            </form>
        </div>
    </div>
</div>
