<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; $rows=$pdo->query('SELECT * FROM proveedor')->fetchAll(); ?>
<!doctype html><html><head><meta charset='utf-8'><title>Proveedores</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4"><a href="dashboard.php" class="btn btn-light mb-3">Volver</a><a class="btn btn-success mb-2" href="provider_create.php">Nuevo proveedor</a>
<table class="table table-bordered"><tr><th>ID</th><th>Nombre</th><th>Tel</th><th>Email</th><th>Acciones</th></tr>
<?php foreach($rows as $r): ?><tr><td><?=$r['idPROVEEDOR']?></td><td><?=htmlspecialchars($r['nomPROVEEDOR'])?></td><td><?=$r['telPROVEEDOR']?></td><td><?=$r['emailPROVEEDOR']?></td>
<td><a class="btn btn-sm btn-primary" href="provider_edit.php?id=<?=$r['idPROVEEDOR']?>">Editar</a>
<a class="btn btn-sm btn-danger" href="provider_delete.php?id=<?=$r['idPROVEEDOR']?>" onclick="return confirm('Eliminar?')">Eliminar</a></td></tr><?php endforeach; ?></table></body></html>