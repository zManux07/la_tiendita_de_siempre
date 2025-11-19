<?php
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: index.php?route=login');
    exit;
}

require_once 'config/Database.php';
require_once 'models/ProductoModel.php';
require_once 'models/CategoriaModel.php';
require_once 'models/ProveedorModel.php';
require_once 'models/UsuarioModel.php';
require_once 'models/FacturaModel.php';
require_once 'models/PagoModel.php';
require_once 'models/EmpleadoModel.php';
require_once 'models/MensajeModel.php';
require_once 'models/EntradaModel.php';

$db = new Database();
$conn = $db->connect();

$productoModel = new ProductoModel($conn);
$categoriaModel = new CategoriaModel($conn);
$proveedorModel = new ProveedorModel($conn);
$usuarioModel = new UsuarioModel($conn);
$facturaModel = new FacturaModel($conn);
$pagoModel = new PagoModel($conn);
$empleadoModel = new EmpleadoModel($conn);
$mensajeModel = new MensajeModel($conn);
$entradaModel = new EntradaModel($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>
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
                        <a class="nav-link" href="index.php?route=index">Tienda</a>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link">Bienvenido, <?= $_SESSION['usuario_nombre'] ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?route=logout">Salir</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="container-fluid my-5">
        <div class="row mb-5">
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Productos</h6>
                        <h2 class="text-primary"><?= $productoModel->obtenerTodos() ? count($productoModel->obtenerTodos()) : 0 ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Categorías</h6>
                        <h2 class="text-primary"><?= $categoriaModel->contar() ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Ventas</h6>
                        <h2 class="text-primary">$<?= number_format($facturaModel->obtenerTotal(), 2) ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="card-title text-muted">Usuarios</h6>
                        <h2 class="text-primary"><?= $usuarioModel->contar() ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mb-4">Gestión</h3>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-blue text-white">
                        <h5 class="mb-0">📦 Inventario</h5>
                    </div>
                    <div class="card-body">
                        <a href="index.php?route=admin/producto/crear" class="btn btn-primary btn-sm mb-2">+ Crear Producto</a>
                        <a href="index.php?route=admin/entrada/crear" class="btn btn-info btn-sm mb-2">+ Entrada de Inventario</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-blue text-white">
                        <h5 class="mb-0">🏷️ Categorías y Proveedores</h5>
                    </div>
                    <div class="card-body">
                        <a href="index.php?route=admin/categoria/crear" class="btn btn-primary btn-sm mb-2">+ Crear Categoría</a>
                        <a href="index.php?route=admin/proveedor/crear" class="btn btn-primary btn-sm mb-2">+ Crear Proveedor</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-blue text-white">
                        <h5 class="mb-0">👥 Usuarios y Empleados</h5>
                    </div>
                    <div class="card-body">
                        <a href="index.php?route=admin/usuario/crear" class="btn btn-primary btn-sm mb-2">+ Crear Usuario</a>
                        <a href="index.php?route=admin/empleado/crear" class="btn btn-primary btn-sm mb-2">+ Crear Empleado</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary-blue text-white">
                        <h5 class="mb-0">💰 Ventas y Pagos</h5>
                    </div>
                    <div class="card-body">
                        <a href="index.php?route=admin/pago/crear" class="btn btn-primary btn-sm mb-2">+ Registrar Pago</a>
                        <a href="index.php?route=admin/mensajes" class="btn btn-warning btn-sm mb-2">📧 Ver Mensajes</a>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mb-4 mt-5">Últimas Actividades</h3>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Facturas Recientes</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $facturas = $facturaModel->obtenerTodas();
                                foreach (array_slice($facturas, 0, 5) as $factura):
                                ?>
                                    <tr>
                                        <td><?= $factura['idFACTURA'] ?></td>
                                        <td><?= htmlspecialchars(substr($factura['nomUSUARIO'], 0, 20)) ?></td>
                                        <td>$<?= number_format($factura['totalFACTURA'], 2) ?></td>
                                        <td><?= date('d/m/Y', strtotime($factura['fechaFACTURA'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">Mensajes de Contacto</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $mensajes = $mensajeModel->obtenerRecientes(5);
                                foreach ($mensajes as $msg):
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars(substr($msg['nombre'], 0, 15)) ?></td>
                                        <td><?= htmlspecialchars(substr($msg['correo'], 0, 15)) ?></td>
                                        <td><?= date('d/m/Y', strtotime($msg['fecha_envio'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
