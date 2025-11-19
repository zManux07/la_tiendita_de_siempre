<?php include 'header.php'; ?>

<?php
require_once 'config/Database.php';
require_once 'models/CategoriaModel.php';

$db = new Database();
$conn = $db->connect();
$categoriaModel = new CategoriaModel($conn);

$categoria = $categoriaModel->obtenerPorId($_GET['id']);
?>

<div class="container my-5">
    <h2 class="mb-4">✏️ Editar Categoría</h2>

    <form action="index.php?route=admin/categoria/actualizar" method="POST" class="card p-4 shadow-sm">
        <input type="hidden" name="idCATEGORIA" value="<?= $categoria['idCATEGORIA'] ?>">

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nomCATEGORIA" class="form-control" value="<?= $categoria['nomCATEGORIA'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcionCATEGORIA" class="form-control" rows="3"><?= $categoria['descripcionCATEGORIA'] ?></textarea>
        </div>

        <button class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php?route=admin/dashboard" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include 'footer.php'; ?>
