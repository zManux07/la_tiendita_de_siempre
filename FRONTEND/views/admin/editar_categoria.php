<?php

if (!isset($_SESSION['usuario_rol']) || 
   ($_SESSION['usuario_rol'] !== 'admin' && $_SESSION['usuario_rol'] !== 'empleado')) {

    header('Location: index.php?route=login');
    exit;
}
$dashboard = ($_SESSION['usuario_rol'] === 'admin') 
    ? 'admin/dashboard' 
    : 'empleado/dashboard';


require_once 'config/Database.php';
require_once 'models/CategoriaModel.php';

$db = new Database();
$conn = $db->connect();
$categoriaModel = new CategoriaModel($conn);

$categoria = $categoriaModel->obtenerPorId($_GET['id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tus estilos -->
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

<!-- CONTENIDO -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow">
                <div class="card-header bg-primary-blue text-white">
                    <h5 class="mb-0">✏️ Editar Categoría</h5>
                </div>

                <div class="card-body p-4">
                    <form action="index.php?route=admin/categoria/editar&id=<?= $categoria['idCATEGORIA'] ?>" method="POST">

                        <input type="hidden" name="idCATEGORIA" value="<?= $categoria['idCATEGORIA'] ?>">

                        <div class="mb-3">
                            <label class="form-label">Nombre de la Categoría</label>
                            <input type="text" name="nomCATEGORIA" class="form-control"
                                   value="<?= $categoria['nomCATEGORIA'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcionCATEGORIA" class="form-control" rows="3"><?= $categoria['descripcionCATEGORIA'] ?></textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php?route=admin/dashboard" class="btn btn-secondary">Cancelar</a>
                            <button class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- FOOTER + BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
