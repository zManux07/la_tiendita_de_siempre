<?php 
require_once 'config/Database.php';
require_once 'models/ProveedorModel.php';

$db = new Database();
$conn = $db->connect();
$proveedorModel = new ProveedorModel($conn);

$proveedor = $proveedorModel->obtenerPorId($_GET['id']);
?>
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
<div class="container my-5">
    <h2 class="mb-4">✏️ Editar Proveedor</h2>

    <form action="index.php?route=admin/proveedor/editar&id=<?= $proveedor['idPROVEEDOR'] ?>" method="POST" class="card p-4 shadow-sm">
       <input type="hidden" name="idPROVEEDOR" value="<?= $proveedor['idPROVEEDOR'] ?>">


        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nomPROVEEDOR" class="form-control" value="<?= $proveedor['nomPROVEEDOR'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telPROVEEDOR" class="form-control" value="<?= $proveedor['telPROVEEDOR'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direcPROVEEDOR" class="form-control" value="<?= $proveedor['direcPROVEEDOR'] ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="emailPROVEEDOR" class="form-control" value="<?= $proveedor['emailPROVEEDOR'] ?>">
        </div>

        <button class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php?route=admin/dashboard" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<!-- FOOTER + BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
