<?php include 'header.php'; ?>

<?php
require_once 'config/Database.php';
require_once 'models/ProductoModel.php';

$db = new Database();
$conn = $db->connect();
$productoModel = new ProductoModel($conn);
$producto = $productoModel->obtenerPorId($_GET['id']);
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <?php if ($producto['fotoPRODUCTO']): ?>
                <img src="<?= htmlspecialchars($producto['fotoPRODUCTO']) ?>" alt="<?= htmlspecialchars($producto['nomPRODUCTO']) ?>" class="img-fluid rounded">
            <?php else: ?>
                <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 400px;">
                    <span class="text-muted">Sin imagen disponible</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h1 class="mb-2"><?= htmlspecialchars($producto['nomPRODUCTO']) ?></h1>
            <p class="text-muted mb-3">Marca: <?= htmlspecialchars($producto['marcaPRODUCTO']) ?></p>
            <p class="text-secondary mb-4">
                Categoría: <a href="index.php?route=catalogo&categoria=<?= $producto['idCATEGORIA'] ?>">
                    <?= htmlspecialchars($producto['nomCATEGORIA']) ?>
                </a>
            </p>

            <div class="mb-4">
                <h2 class="text-primary">$<?= number_format($producto['precioPRODUCTO'], 2) ?></h2>
                <p class="lead">
                    <?php if ($producto['cantidadenstockPRODUCTO'] > 0): ?>
                        <span class="badge bg-success">En Stock</span>
                        <br><small class="text-secondary">Disponibles: <?= $producto['cantidadenstockPRODUCTO'] ?></small>
                    <?php else: ?>
                        <span class="badge bg-danger">Agotado</span>
                    <?php endif; ?>
                </p>
            </div>

            <div class="mb-4">
                <p><strong>Unidad de Medida:</strong> <?= htmlspecialchars($producto['unidadMedidaPRODUCTO']) ?></p>
                <p><strong>Proveedor:</strong> <?= htmlspecialchars($producto['nomPROVEEDOR']) ?></p>
            </div>

            <?php if ($producto['cantidadenstockPRODUCTO'] > 0): ?>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <form id="formAgregar" class="mb-4">
                        <div class="input-group mb-3">
                            <label class="input-group-text">Cantidad:</label>
                            <input type="number" class="form-control" id="cantidad" name="cantidad" value="1" min="1" max="<?= $producto['cantidadenstockPRODUCTO'] ?>" required>
                        </div>
                        <input type="hidden" name="idProducto" value="<?= $producto['idPRODUCTO'] ?>">
                        <button type="submit" class="btn btn-primary btn-lg w-100">Agregar al Carrito</button>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <a href="index.php?route=login" class="btn btn-primary">Inicia sesión para comprar</a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <a href="index.php?route=catalogo" class="btn btn-secondary">Volver al Catálogo</a>
        </div>
    </div>
</div>

<script>
document.getElementById('formAgregar')?.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('index.php?route=carrito/agregar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});
</script>

<?php include 'footer.php'; ?>
