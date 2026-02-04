<?php
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: index.php?route=login');
    exit;
}
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/FacturaModel.php';
$db = new Database();
$conn = $db->connect();
$facturaModel = new FacturaModel($conn);
$facturaId = $_GET['id'] ?? null;
if (!$facturaId) {
    header('Location: index.php?route=admin/factura/listar');
    exit;
}
$factura = $facturaModel->obtenerPorId($facturaId); 
$detalles = $facturaModel->obtenerDetallesPorFacturaId($facturaId);
if (!$factura) {
    header('Location: index.php?route=admin/factura/listar');
    exit;
}
                
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Factura</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark-blue">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php?route=admin/dashboard">
            🏢 Dashboard Admin
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?route=admin/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?route=admin/factura/listar">Facturas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?route=logout">Salir</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- CONTENIDO -->
<div class="container my-5">

    <h2 class="mb-4">🧾 Detalle de Factura</h2>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>ID Factura:</strong> <?= $factura['idFACTURA'] ?></p>
            <p><strong>Cliente:</strong> <?= htmlspecialchars($factura['nomUSUARIO']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($factura['emailUSUARIO']) ?></p>
            <p><strong>Fecha:</strong> <?= date('d/m/Y', strtotime($factura['fechaFACTURA'])) ?></p>
            <p><strong>Total:</strong> $<?= number_format($factura['totalFACTURA'], 2) ?></p>
        </div>
    </div>

    <h4 class="mb-3">🛒 Productos comprados</h4>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($detalles)) : ?>
            <?php foreach ($detalles as $d): ?>
                <tr>
                    <td><?= htmlspecialchars($d['nomPRODUCTO']) ?></td>
                    <td><?= $d['cantiSalidaDETALLESALIDA'] ?></td>
                    <td>$<?= number_format($d['valorunitarioDETALLESALIDA'], 2) ?></td>
                    <td>$<?= number_format($d['valorTotalventaDETALLESALIDA'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="4" class="text-center">No hay productos en esta factura.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <div class="mt-4">
        <a href="index.php?route=admin/factura/listar" class="btn btn-secondary">
            ← Volver a Facturas
        </a>

        <a href="pdf/factura.php?id=<?= $factura['idFACTURA'] ?>" 
           class="btn btn-danger" target="_blank">
            📄 Descargar PDF
        </a>
    </div>

</div>

</body>
</html>
