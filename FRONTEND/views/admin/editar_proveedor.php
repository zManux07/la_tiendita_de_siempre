<?php include 'header.php'; ?>

<?php
require_once 'config/Database.php';
require_once 'models/ProveedorModel.php';

$db = new Database();
$conn = $db->connect();
$proveedorModel = new ProveedorModel($conn);

$proveedor = $proveedorModel->obtenerPorId($_GET['id']);
?>

<div class="container my-5">
    <h2 class="mb-4">✏️ Editar Proveedor</h2>

    <form action="index.php?route=admin/proveedor/actualizar" method="POST" class="card p-4 shadow-sm">
        <input type="hidden" name="idPROVEEDOR" value="<?= $proveedor['idPROVEEDOR'] ?>">

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nomPROVEEDOR" class="form-control" value="<?= $proveedor['nomPROVEEDOR'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telPROVEEDOR" class="form-control" value="<?= $proveedor['telPROVEEDOR'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direcPROVEEDOR" class="form-control" value="<?= $proveedor['direcPROVEEDOR'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="emailPROVEEDOR" class="form-control" value="<?= $proveedor['emailPROVEEDOR'] ?>">
        </div>

        <button class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php?route=admin/dashboard" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include 'footer.php'; ?>
