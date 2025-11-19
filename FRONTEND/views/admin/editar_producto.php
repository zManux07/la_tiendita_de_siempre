<?php include 'header.php'; ?>

<?php
require_once 'config/Database.php';
require_once 'models/ProductoModel.php';
require_once 'models/CategoriaModel.php';
require_once 'models/ProveedorModel.php';

$db = new Database();
$conn = $db->connect();

$productoModel = new ProductoModel($conn);
$categoriaModel = new CategoriaModel($conn);
$proveedorModel = new ProveedorModel($conn);

$producto = $productoModel->obtenerPorId($_GET['id']);
$categorias = $categoriaModel->obtenerTodas();
$proveedores = $proveedorModel->obtenerTodos();
?>

<div class="container my-5">
    <h2 class="mb-4">✏️ Editar Producto</h2>

    <form action="index.php?route=admin/producto/actualizar" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        <input type="hidden" name="idPRODUCTO" value="<?= $producto['idPRODUCTO'] ?>">

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nomPRODUCTO" class="form-control" value="<?= $producto['nomPRODUCTO'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Marca</label>
            <input type="text" name="marcaPRODUCTO" class="form-control" value="<?= $producto['marcaPRODUCTO'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" name="precioPRODUCTO" class="form-control" value="<?= $producto['precioPRODUCTO'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Unidad de medida</label>
            <input type="text" name="unidadMedidaPRODUCTO" class="form-control" value="<?= $producto['unidadMedidaPRODUCTO'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Categoría</label>
            <select name="idCATEGORIA" class="form-select">
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['idCATEGORIA'] ?>" <?= $producto['idCATEGORIA'] == $cat['idCATEGORIA'] ? 'selected' : '' ?>>
                        <?= $cat['nomCATEGORIA'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Proveedor</label>
            <select name="idPROVEEDOR" class="form-select">
                <?php foreach ($proveedores as $prov): ?>
                    <option value="<?= $prov['idPROVEEDOR'] ?>" <?= $producto['idPROVEEDOR'] == $prov['idPROVEEDOR'] ? 'selected' : '' ?>>
                        <?= $prov['nomPROVEEDOR'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Foto actual</label><br>
            <img src="<?= $producto['fotoPRODUCTO'] ?>" class="img-fluid rounded mb-2" style="max-width:200px;">
            <input type="file" name="fotoPRODUCTO" class="form-control mt-2">
        </div>

        <button class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php?route=admin/dashboard" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?php include 'footer.php'; ?>
