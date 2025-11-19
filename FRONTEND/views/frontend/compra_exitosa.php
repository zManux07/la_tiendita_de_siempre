<?php include 'header.php'; ?>

<?php
require_once 'config/Database.php';
require_once 'models/FacturaModel.php';
require_once 'models/DetalleSalidaModel.php';

$db = new Database();
$conn = $db->connect();
$facturaModel = new FacturaModel($conn);
$detalleSalidaModel = new DetalleSalidaModel($conn);

$factura = $facturaModel->obtenerPorId($_GET['id']);
$detalles = $detalleSalidaModel->obtenerPorFactura($_GET['id']);
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-success text-center mb-4">
                <h1 class="display-4">✓ ¡Compra Exitosa!</h1>
                <p class="lead">Tu pedido ha sido procesado correctamente</p>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header bg-primary-blue text-white">
                    <h5 class="mb-0">Detalles de tu Factura</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Número de Factura:</strong> #<?= $factura['idFACTURA'] ?></p>
                            <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($factura['fechaFACTURA'])) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Cliente:</strong> <?= htmlspecialchars($factura['nomUSUARIO']) ?></p>
                            <p><strong>Email:</strong> <?= htmlspecialchars($factura['emailUSUARIO']) ?></p>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Productos Comprados:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($detalles as $detalle): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($detalle['nomPRODUCTO']) ?></td>
                                        <td><?= $detalle['cantiSalidaDETALLESALIDA'] ?></td>
                                        <td>$<?= number_format($detalle['valorunitarioDETALLESALIDA'], 2) ?></td>
                                        <td>$<?= number_format($detalle['valorTotalventaDETALLESALIDA'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-end">
                        <h5 class="text-primary">Total: $<?= number_format($factura['totalFACTURA'], 2) ?></h5>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <p class="text-muted mb-3">Recibirás un email de confirmación pronto</p>
                <a href="index.php?route=index" class="btn btn-primary btn-lg">Volver al Inicio</a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
