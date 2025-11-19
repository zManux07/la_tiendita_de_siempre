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
    <title>Crear Entrada de Inventario</title>
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
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-header bg-primary-blue text-white">
                        <h5 class="mb-0">📥 Registrar Entrada de Inventario</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="index.php?route=admin/entrada/crear" class="needs-validation">
                            <div class="mb-3">
                                <label for="idPRODUCTO" class="form-label">Producto</label>
                                <select class="form-select" id="idPRODUCTO" name="idPRODUCTO" required>
                                    <option value="">Selecciona un producto</option>
                                    <?php foreach ($productos as $prod): ?>
                                        <option value="<?= $prod['idPRODUCTO'] ?>"><?= htmlspecialchars($prod['nomPRODUCTO']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cantIngreENTRADA" class="form-label">Cantidad</label>
                                    <input type="number" class="form-control" id="cantIngreENTRADA" name="cantIngreENTRADA" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="codigo" class="form-label">Código de Entrada</label>
                                    <input type="text" class="form-control" id="codigo" name="codigo">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="precioCompraUnid" class="form-label">Precio de Compra (Unitario)</label>
                                <input type="number" class="form-control" id="precioCompraUnid" name="precioCompraUnid" step="0.01" required>
                            </div>

                            <div class="alert alert-info">
                                <strong>Nota:</strong> La cantidad se agregará al stock del producto automáticamente.
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="index.php?route=admin/dashboard" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Registrar Entrada</button>
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
