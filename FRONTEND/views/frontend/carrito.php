<?php include 'header.php'; ?>

<?php
if (!isset($_SESSION['usuario_id'])) {
    header('Location: index.php?route=login');
    exit;
}

require_once 'config/Database.php';
require_once 'models/CarritoModel.php';

$db = new Database();
$conn = $db->connect();
$carritoModel = new CarritoModel($conn);
$items = $carritoModel->obtenerPorUsuario($_SESSION['usuario_id']);
?>

<div class="container my-5">
    <h2 class="mb-4">Mi Carrito de Compras</h2>

    <?php if (empty($items)): ?>
        <div class="alert alert-info">
            El carrito está vacío. <a href="index.php?route=catalogo">Ir al catálogo</a>
        </div>
    <?php else: ?>
        <div class="table-responsive mb-4">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($items as $item):
                        $subtotal = $item['precioPRODUCTO'] * $item['cantidad'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if ($item['fotoPRODUCTO']): ?>
                                        <img src="<?= htmlspecialchars($item['fotoPRODUCTO']) ?>" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; margin-right: 10px;">
                                    <?php endif; ?>
                                    <strong><?= htmlspecialchars($item['nomPRODUCTO']) ?></strong>
                                </div>
                            </td>
                            <td>$<?= number_format($item['precioPRODUCTO'], 2) ?></td>
                            <td>
                                <input type="number" class="form-control cantidad" value="<?= $item['cantidad'] ?>" min="1" data-carrito="<?= $item['idCarrito'] ?>" style="width: 70px;">
                            </td>
                            <td class="fw-bold">$<?= number_format($subtotal, 2) ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm btnEliminar" data-carrito="<?= $item['idCarrito'] ?>">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-8">
                <a href="index.php?route=catalogo" class="btn btn-secondary">Continuar Comprando</a>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Resumen</h5>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong class="text-primary fs-5">$<span id="totalCarrito"><?= number_format($total, 2) ?></span></strong>
                        </div>
                        <form action="index.php?route=factura/procesar" method="POST">
                            <button type="submit" class="btn btn-primary w-100 btn-lg">Procesar Compra</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.querySelectorAll('.cantidad').forEach(input => {
    input.addEventListener('change', function() {
        const idCarrito = this.dataset.carrito;
        const cantidad = this.value;

        fetch('index.php?route=carrito/actualizar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'idCarrito=' + idCarrito + '&cantidad=' + cantidad
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    });
});

document.querySelectorAll('.btnEliminar').forEach(btn => {
    btn.addEventListener('click', function() {
        if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
            const idCarrito = this.dataset.carrito;

            fetch('index.php?route=carrito/eliminar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'idCarrito=' + idCarrito
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    });
});
</script>

<?php include 'footer.php'; ?>
