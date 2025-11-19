<?php
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: index.php?route=login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark-blue">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="index.php?route=admin/dashboard">🏢 Dashboard Admin</a>
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

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary-blue text-white">
                        <h5 class="mb-0">💳 Registrar Pago</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="index.php?route=admin/pago/crear" class="needs-validation">
                            <div class="mb-3">
                                <label for="idFactura" class="form-label">Factura</label>
                                <select class="form-select" id="idFactura" name="idFactura" required>
                                    <option value="">Selecciona una factura</option>
                                    <?php foreach ($facturas as $fact): ?>
                                        <option value="<?= $fact['idFACTURA'] ?>">
                                            #<?= $fact['idFACTURA'] ?> - <?= htmlspecialchars($fact['nomUSUARIO']) ?> ($<?= number_format($fact['totalFACTURA'], 2) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="metodo_pago" class="form-label">Método de Pago</label>
                                <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                    <option value="">Selecciona un método</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Tarjeta">Tarjeta de Crédito/Débito</option>
                                    <option value="Transferencia">Transferencia Bancaria</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="monto" class="form-label">Monto</label>
                                <input type="number" class="form-control" id="monto" name="monto" step="0.01" required>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="index.php?route=admin/dashboard" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Registrar Pago</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
