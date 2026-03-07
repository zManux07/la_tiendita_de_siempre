<?php

if (!isset($_SESSION['usuario_rol']) || 
   ($_SESSION['usuario_rol'] !== 'admin' && $_SESSION['usuario_rol'] !== 'empleado')) {

    header('Location: index.php?route=login');
    exit;
}

$dashboard = ($_SESSION['usuario_rol'] === 'admin') 
    ? 'admin/dashboard' 
    : 'empleado/dashboard';

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/FacturaModel.php';
$db = new Database();
$conn = $db->connect();
$facturaModel = new FacturaModel($conn);
$facturas = $facturaModel->obtenerTodas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Facturas</title>
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
                    <a class="nav-link" href="index.php?route=logout">Salir</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- CONTENIDO -->
<div class="container my-5">

    <h2 class="mb-4">🧾 Gestionar Facturas</h2>

    <a href="index.php?route=<?= $dashboard ?>" class="btn btn-secondary mb-3">
        ← Volver
    </a>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Email</th>
                <th>Total</th>
                <th>Fecha</th>
                <th style="width: 180px;">Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php if (!empty($facturas)) : ?>
            <?php foreach ($facturas as $f): ?>
                <tr>
                    <td><?= $f['idFACTURA'] ?></td>
                    <td><?= htmlspecialchars($f['nomUSUARIO']) ?></td>
                    <td><?= htmlspecialchars($f['emailUSUARIO']) ?></td>
                    <td>$<?= number_format($f['totalFACTURA'], 2) ?></td>
                    <td><?= date('d/m/Y', strtotime($f['fechaFACTURA'])) ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="index.php?route=admin/factura/ver&id=<?= $f['idFACTURA'] ?>"
                               class="btn btn-sm btn-info">
                                👁 Ver
                            </a>
                            <a href="pdf/factura.php?id=<?= $f['idFACTURA'] ?>"
                               class="btn btn-sm btn-danger" target="_blank">
                                📄 PDF
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="6" class="text-center">
                    No hay facturas registradas.
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- PAGINACIÓN (si luego la usas) -->
    <?php if (!empty($totalPaginas) && $totalPaginas > 1): ?>
    <nav>
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                <li class="page-item <?= ($i == ($paginaActual ?? 1)) ? 'active' : '' ?>">
                    <a class="page-link"
                       href="index.php?route=admin/factura/listar&pagina=<?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>

</div>

</body>
</html>
