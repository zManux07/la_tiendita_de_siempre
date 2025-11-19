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
    <title>Crear Producto</title>
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
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary-blue text-white">
                        <h5 class="mb-0">📦 Crear Nuevo Producto</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="index.php?route=admin/producto/crear" enctype="multipart/form-data" class="needs-validation">
                            <div class="mb-3">
                                <label for="nomPRODUCTO" class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control" id="nomPRODUCTO" name="nomPRODUCTO" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="marcaPRODUCTO" class="form-label">Marca</label>
                                    <input type="text" class="form-control" id="marcaPRODUCTO" name="marcaPRODUCTO">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="precioPRODUCTO" class="form-label">Precio</label>
                                    <input type="number" class="form-control" id="precioPRODUCTO" name="precioPRODUCTO" step="0.01" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cantidadenstockPRODUCTO" class="form-label">Cantidad en Stock</label>
                                    <input type="number" class="form-control" id="cantidadenstockPRODUCTO" name="cantidadenstockPRODUCTO" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="unidadMedidaPRODUCTO" class="form-label">Unidad de Medida</label>
                                    <select class="form-select" id="unidadMedidaPRODUCTO" name="unidadMedidaPRODUCTO" required>
                                        <option value="">Selecciona...</option>
                                        <option value="Kg">Kilogramos</option>
                                        <option value="L">Litros</option>
                                        <option value="Und">Unidades</option>
                                        <option value="M">Metros</option>
                                        <option value="M2">Metros Cuadrados</option>
                                        <option value="Caja">Cajas</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="idCATEGORIA" class="form-label">Categoría</label>
                                    <select class="form-select" id="idCATEGORIA" name="idCATEGORIA" required>
                                        <option value="">Selecciona una categoría</option>
                                        <?php foreach ($categorias as $cat): ?>
                                            <option value="<?= $cat['idCATEGORIA'] ?>"><?= htmlspecialchars($cat['nomCATEGORIA']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="idPROVEEDOR" class="form-label">Proveedor</label>
                                    <select class="form-select" id="idPROVEEDOR" name="idPROVEEDOR" required>
                                        <option value="">Selecciona un proveedor</option>
                                        <?php foreach ($proveedores as $prov): ?>
                                            <option value="<?= $prov['idPROVEEDOR'] ?>"><?= htmlspecialchars($prov['nomPROVEEDOR']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="fotoPRODUCTO" class="form-label">Imagen del Producto</label>
                                <input type="file" class="form-control" id="fotoPRODUCTO" name="fotoPRODUCTO" accept="image/*">
                                <small class="text-muted">JPG, PNG (máx. 5MB)</small>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="destacado" name="destacado" value="1">
                                <label class="form-check-label" for="destacado">
                                Mostrar en la página principal (Destacado)
                                </label>
</div>


                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="index.php?route=admin/dashboard" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Crear Producto</button>
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
