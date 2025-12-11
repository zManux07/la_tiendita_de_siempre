<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/ProveedorModel.php';

$db = new Database();
$conn = $db->connect();
$proveedorModel = new ProveedorModel($conn);

$proveedores = $proveedorModel->obtenerTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Proveedores</title>

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
                <li class="nav-item"><a class="nav-link" href="index.php?route=admin/dashboard">Dashboard</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?route=logout">Salir</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">

    <h2 class="mb-4">Gestionar Proveedores</h2>

    <a href="index.php?route=admin/proveedor/crear" class="btn btn-primary mb-3">+ Crear Proveedor</a>
    <a href="index.php?route=admin/dashboard" class="btn btn-secondary mb-3">← Volver</a>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th style="width: 150px;">Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($proveedores as $prov): ?>
            <tr>
                <td><?= $prov['idPROVEEDOR'] ?></td>
                <td><?= $prov['nomPROVEEDOR'] ?></td>
                <td><?= $prov['telPROVEEDOR'] ?></td>
                <td><?= $prov['emailPROVEEDOR'] ?></td>

                <td>
                    <div class="btn-group">
                    <a href="index.php?route=admin/proveedor/editar&id=<?= $prov['idPROVEEDOR'] ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="index.php?route=admin/proveedor/eliminar&id=<?= $prov['idPROVEEDOR'] ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('¿Eliminar este proveedor?');">Eliminar</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>

</div>
</body>
</html>
