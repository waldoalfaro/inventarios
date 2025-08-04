<?php
include '../header.php';
include '../conexion.php';


$sql = "SELECT * FROM usuarios";
$stmt = $conexion->prepare($sql); 
$stmt->execute(); 

$usuarios = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$sqlTipos = "SELECT idtipo, tipo FROM tipo_usuario";
$stmtTipos = $conexion->prepare($sqlTipos);
$stmtTipos->execute();
$tiposUsuario = $stmtTipos->get_result()->fetch_all(MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/alertify.js/1.13.1/alertify.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/alertify.js/1.13.1/themes/default.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
</head>
<body>


<div class="container mt-5">
<a href="#" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#ModalRegUsuario">
        <i class="fa-solid fa-user-plus"></i> Agregar Usuario
    </a>
    <table class="table table-hover table-bordered text-center" style="margin-top: 20px;">
    <thead class="bg-info text-white">
        <tr>
            <th>N</th>
            <th>Usuario</th>
            <th>Email</th>
            <th colspan="2">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $row): ?>
            <tr>
                <td><?= $row["idusuario"] ?></td>
                <td><?= $row["usuario"] ?></td>
                <td><?= $row["email"] ?></td>
                <td>
                    <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ModalEditUsuario" 
                       data-id="<?= $row["idusuario"] ?>" data-usuario="<?= $row["usuario"] ?>" 
                       data-email="<?= $row["email"] ?>" data-tipo="<?= $row["tipo"] ?>">
                       <i class="fa-solid fa-edit"></i> Editar
                    </a>
                    <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete(<?= $row['idusuario'] ?>)">
                        <i class="fa-solid fa-trash"></i> Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>
<div class="modal fade" id="ModalRegUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="agregar.php" method="POST">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="email" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Tipo Usuario</label>
                        <select class="form-control" name="tipo_usuario" id="tipo_usuario" required>
                            <option value="">Seleccione un tipo</option>
                            <?php foreach ($tiposUsuario as $tipo): ?>
                                <option value="<?= $tipo['idtipo'] ?>"><?= $tipo['tipo'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Editar Usuario -->
<div class="modal fade" id="ModalEditUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="editar.php" method="POST">
                    <input type="hidden" id="edit_idusuario" name="idusuario">
                    <div class="mb-3">
                        <label for="edit_usuario" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="edit_usuario" name="usuario" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="edit_email" name="correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tipo_usuario" class="form-label">Tipo Usuario</label>
                        <select class="form-control" name="tipo_usuario" id="edit_tipo_usuario" required>
                            <option value="">Seleccione un tipo</option>
                            <?php foreach ($tiposUsuario as $tipo): ?>
                                <option value="<?= $tipo['idtipo'] ?>"><?= $tipo['tipo'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/alertify.js/1.13.1/alertify.min.js"></script>

<script>
    // Rellenar los campos del modal de edición
    var editModal = document.getElementById('ModalEditUsuario');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Botón que activó el modal
        var id = button.getAttribute('data-id');
        var usuario = button.getAttribute('data-usuario');
        var email = button.getAttribute('data-email');
        var tipo = button.getAttribute('data-tipo');

        // Actualizar los campos del modal
        var modalId = editModal.querySelector('#edit_idusuario');
        var modalUsuario = editModal.querySelector('#edit_usuario');
        var modalEmail = editModal.querySelector('#edit_email');
        var modalTipo = editModal.querySelector('#edit_tipo_usuario');

        modalId.value = id;
        modalUsuario.value = usuario;
        modalEmail.value = email;
        modalTipo.value = tipo;
    });

    // Función para eliminar usuario
    function confirmDelete(id) {
        if (confirm("¿Está seguro de que desea eliminar este usuario?")) {
            window.location.href = 'eliminar.php?id=' + id;
        }
    }




</script>

</body>
</html>
