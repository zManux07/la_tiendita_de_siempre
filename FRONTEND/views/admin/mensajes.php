<?php
if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: index.php?route=login');
    exit;
}

require_once 'config/Database.php';
require_once 'models/MensajeModel.php';

$db = new Database();
$conn = $db->connect();
$mensajeModel = new MensajeModel($conn);
$mensajes = $mensajeModel->obtenerTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes de Contacto</title>
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
        <h2 class="mb-4">📧 Mensajes de Contacto</h2>

        <?php if (empty($mensajes)): ?>
            <div class="alert alert-info">No hay mensajes</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mensajes as $msg): ?>
                            <tr>
                                <td><?= $msg['id_mensaje'] ?></td>
                                <td><?= htmlspecialchars($msg['nombre']) ?></td>
                                <td><?= htmlspecialchars($msg['correo']) ?></td>
                                <td><?= htmlspecialchars($msg['telefono']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($msg['fecha_envio'])) ?></td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal<?= $msg['id_mensaje'] ?>">
                                        Ver
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="modal<?= $msg['id_mensaje'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary-blue text-white">
                                            <h5 class="modal-title">Mensaje de <?= htmlspecialchars($msg['nombre']) ?></h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>Nombre:</strong> <?= htmlspecialchars($msg['nombre']) ?></p>
                                            <p><strong>Email:</strong> <?= htmlspecialchars($msg['correo']) ?></p>
                                            <p><strong>Teléfono:</strong> <?= htmlspecialchars($msg['telefono']) ?></p>
                                            <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($msg['fecha_envio'])) ?></p>
                                            <hr>
                                            <p><strong>Mensaje:</strong></p>
                                            <p><?= nl2br(htmlspecialchars($msg['mensaje'])) ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            <a href="mailto:<?= htmlspecialchars($msg['correo']) ?>" class="btn btn-primary">Responder</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="index.php?route=admin/dashboard" class="btn btn-secondary mt-3">Volver al Dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
