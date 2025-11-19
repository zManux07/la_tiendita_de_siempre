<?php include 'header.php'; ?>

<?php
require_once 'config/Database.php';
require_once 'models/UsuarioModel.php';

$db = new Database();
$conn = $db->connect();
$usuarioModel = new UsuarioModel($conn);

$usuario = $usuarioModel->obtenerPorId($_GET['id']);
?>

<div class="container my-5">
    <h2 class="mb-4">✏️ Editar Usuario</h2>

    <form action="index.php?route=admin/usuario/actualizar" method="POST" class="card p-4 shadow-sm">
        <input type="hidden" name="idUSUARIO" value="<?= $usuario['idUSUARIO'] ?>">

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nomUSUARIO" class="form-control" value="<?= $usuario['nomUSUARIO'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="emailUSUARIO" class="form-control" value="<?= $usuario['emailUSUARIO'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Rol</label>
            <select name="rolUSUARIO" class="form-select">
                <option value="admin" <?= $usuario['rolUSUARIO'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="cliente" <?= $usuario['rolUSUARIO'] == 'cliente' ? 'selected' : '' ?>>Cliente</option>
            </select>
        </div>

        <button class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php?route=admin/dashboard" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include 'footer.php'; ?>
