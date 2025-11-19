<?php include 'header.php'; ?>

<?php
require_once 'config/Database.php';
require_once 'models/EmpleadoModel.php';

$db = new Database();
$conn = $db->connect();
$empleadoModel = new EmpleadoModel($conn);

$empleado = $empleadoModel->obtenerPorId($_GET['id']);
?>

<div class="container my-5">
    <h2 class="mb-4">✏️ Editar Empleado</h2>

    <form action="index.php?route=admin/empleado/actualizar" method="POST" class="card p-4 shadow-sm">
        <input type="hidden" name="id_empleado" value="<?= $empleado['id_empleado'] ?>">

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= $empleado['nombre'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cargo</label>
            <input type="text" name="cargo" class="form-control" value="<?= $empleado['cargo'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control" value="<?= $empleado['correo'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?= $empleado['telefono'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de ingreso</label>
            <input type="date" name="fecha_ingreso" class="form-control" value="<?= $empleado['fecha_ingreso'] ?>">
        </div>

        <button class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php?route=admin/dashboard" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include 'footer.php'; ?>
