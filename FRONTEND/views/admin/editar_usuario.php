<?php 
require_once 'config/Database.php';
require_once 'models/UsuarioModel.php';

$db = new Database();
$conn = $db->connect();
$usuarioModel = new UsuarioModel($conn);

$usuario = $usuarioModel->obtenerPorId($_GET['id']);
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
    <h2 class="mb-4">✏️ Editar Usuario</h2>

    <form action="index.php?route=admin/empleado/editar&id=<?= $empleado['id_empleado'] ?>" method="POST" class="card p-4 shadow-sm">
        <input type="hidden" name="idUSUARIO" value="<?= $usuario['idUSUARIO'] ?>">

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nomUSUARIO" class="form-control" value="<?= $usuario['nomUSUARIO'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="emailUSUARIO" class="form-control" value="<?= $usuario['emailUSUARIO'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Rol</label>
            <select name="rolUSUARIO" class="form-select">
                <option value="admin" <?= $usuario['rolUSUARIO'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="cliente" <?= $usuario['rolUSUARIO'] == 'cliente' ? 'selected' : '' ?>>Cliente</option>
            </select>
        </div>
        <div class="mb-3">
            <label class ="form-label">Contraseña (dejar en blanco para no cambiar)</label>
            <input type="password" name="pass" class="form-control">
        </div>
        <div><label for="tipodoc" class="form-label">Tipo de Documento</label>
                                    <select class="form-select" id="tipodoc" name="tipodocumenUSUARIO" required>
                                        <option value="CC">Cédula</option>
                                        <option value="TI">Tarjeta de Identidad</option>
                                        <option value="PAS">Pasaporte</option>
                                    </select>
                                    </div>
<div class="mb-3">
    <label class="form-label">Número de Documento</label>
    <input type="text" name="numdocUSUARIO" class="form-control" 
           value="<?= $usuario['numdocUSUARIO'] ?>" required>
</div>





        <button class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php?route=admin/dashboard" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<!-- FOOTER + BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
