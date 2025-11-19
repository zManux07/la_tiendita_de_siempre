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
    <title>Crear Proveedor</title>
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
                        <h5 class="mb-0">🏭 Crear Nuevo Proveedor</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="index.php?route=admin/proveedor/crear" class="needs-validation">
                            <div class="mb-3">
                                <label for="nomPROVEEDOR" class="form-label">Nombre del Proveedor</label>
                                <input type="text" class="form-control" id="nomPROVEEDOR" name="nomPROVEEDOR" required>
                            </div>

                            <div class="mb-3">
                                <label for="emailPROVEEDOR" class="form-label">Email</label>
                                <input type="email" class="form-control" id="emailPROVEEDOR" name="emailPROVEEDOR">
                            </div>

                            <div class="mb-3">
                                <label for="telPROVEEDOR" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telPROVEEDOR" name="telPROVEEDOR">
                            </div>

                            <div class="mb-3">
                                <label for="direcPROVEEDOR" class="form-label">Dirección</label>
                                <textarea class="form-control" id="direcPROVEEDOR" name="direcPROVEEDOR" rows="3"></textarea>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="index.php?route=admin/dashboard" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Crear Proveedor</button>
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
