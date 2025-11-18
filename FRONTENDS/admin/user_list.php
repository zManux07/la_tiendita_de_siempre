<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; $rows=$pdo->query('SELECT * FROM usuario')->fetchAll(); ?>
<!doctype html><html><head><meta charset='utf-8'><title>Usuarios</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4"><a href="dashboard.php" class="btn btn-light mb-3">Volver</a><a class="btn btn-success mb-2" href="user_create.php">Nuevo usuario</a>
<table class="table table-bordered"><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Acciones</th></tr>
<?php foreach($rows as $r): ?><tr><td><?=$r['idUSUARIO']?></td><td><?=htmlspecialchars($r['nomUSUARIO'])?></td><td><?=$r['emailUSUARIO']?></td><td><?=$r['rolUSUARIO']?></td>
<td><a class="btn btn-sm btn-primary" href="user_edit.php?id=<?=$r['idUSUARIO']?>">Editar</a>
<a class="btn btn-sm btn-danger" href="user_delete.php?id=<?=$r['idUSUARIO']?>" onclick="return confirm('Eliminar?')">Eliminar</a></td></tr><?php endforeach; ?></table></body></html>