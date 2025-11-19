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
    <title>Crear Usuario</title>
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
                        <h5 class="mb-0">👥 Crear Nuevo Usuario</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="index.php?route=admin/usuario/crear" class="needs-validation">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="tipodoc" class="form-label">Tipo de Documento</label>
                                    <select class="form-select" id="tipodoc" name="tipodocumenUSUARIO" required>
                                        <option value="CC">Cédula</option>
                                        <option value="TI">Tarjeta de Identidad</option>
                                        <option value="PAS">Pasaporte</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="numdoc" class="form-label">Número de Documento</label>
                                    <input type="text" class="form-control" id="numdoc" name="numdocUSUARIO" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" name="nomUSUARIO" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="emailUSUARIO" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telUSUARIO">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direcUSUARIO">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="rol" class="form-label">Rol</label>
                                    <select class="form-select" id="rol" name="rolUSUARIO" required>
                                        <option value="cliente">Cliente</option>
                                        <option value="admin">Administrador</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cargo" class="form-label">Cargo</label>
                                    <input type="text" class="form-control" id="cargo" name="cargoUSUARIO">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="pass" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="pass" name="pass" required minlength="6">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="pass_confirm" class="form-label">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" id="pass_confirm" name="pass_confirm" required minlength="6">
                                </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="index.php?route=admin/dashboard" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Crear Usuario</button>
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
