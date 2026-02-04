<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagos Registrados</title>
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
            💰 Dashboard Admin
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
                    <a class="nav-link active" href="index.php?route=admin/pagos/ver">Pagos</a>
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

    <h2 class="mb-4">💳 Pagos Registrados</h2>

    <div class="card shadow-sm">
        <div class="card-body">

            <?php if (!empty($pagos)) : ?>

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Método</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Detalles</th>
                    </tr>
                </thead>
                 <tbody>
        <?php foreach ($pagos as $pago): ?>
            <tr>
                <td><?= $pago['idPago'] ?></td>
                <td><?= $pago['idFactura'] ?></td>
                <td><?= $pago['metodo_pago'] ?></td>
                <td>$<?= number_format($pago['monto'], 0, ',', '.') ?></td>
                <td><?= date('d/m/Y H:i', strtotime($pago['fecha_pago'])) ?></td>
                <td>
                    <a href="index.php?route=admin/pagos/detalle&id=<?= $pago['idPago'] ?>"
                       class="btn btn-sm btn-primary">
                        👁 Ver detalles
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <?php else : ?>
                <p class="text-center mb-0">No hay pagos registrados.</p>
            <?php endif; ?>

        </div>
    </div>

</div>

</body>
</html>
