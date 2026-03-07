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
require_once __DIR__ . '/../../models/ProductoModel.php';

$db = new Database();
$conn = $db->connect();
$productoModel = new ProductoModel($conn);

$productos = $productoModel->obtenerTodos(); // Usa tu método correspondiente
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Productos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>

<!-- NAVBAR -->
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

    <h2 class="mb-4">Gestionar Productos</h2>

    <a href="index.php?route=admin/producto/crear" class="btn btn-primary mb-3">+ Crear Producto</a>
    <a href="index.php?route=<?= $dashboard ?>" class="btn btn-secondary mb-3">← Volver</a>

    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categoría</th>
                <th>Proveedor</th>

                <th style="width: 150px;">Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($productos as $p): ?>
            <tr>
                <td><?= $p['idPRODUCTO'] ?></td>
                <td><?= $p['nomPRODUCTO'] ?></td>
                <td>$<?= $p['precioPRODUCTO'] ?></td>
                <td><?= $p['cantidadenstockPRODUCTO'] ?></td>
                <td><?= $p['idCATEGORIA'] ?></td>
                <td><?= $p['idPROVEEDOR'] ?></td>

                <td>
                    <div class="btn-group">
                        <a href="index.php?route=admin/producto/editar&id=<?= $p['idPRODUCTO'] ?>" 
                           class="btn btn-sm btn-warning">Editar</a>
                        <a href="index.php?route=admin/producto/eliminar&id=<?= $p['idPRODUCTO'] ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('¿Eliminar este producto?');">Eliminar</a>
                    </div>
                </td>


            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>

</div>
</body>
</html>
