<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; $rows=$pdo->query('SELECT * FROM categoria')->fetchAll(); ?>
<!doctype html><html><head><meta charset='utf-8'><title>Categorías</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4"><a href="dashboard.php" class="btn btn-light mb-3">Volver</a>
<a class="btn btn-success mb-2" href="category_create.php">Nueva categoría</a>
<table class="table table-bordered"><tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Acciones</th></tr>
<?php foreach($rows as $r): ?><tr><td><?=$r['idCATEGORIA']?></td><td><?=htmlspecialchars($r['nomCATEGORIA'])?></td><td><?=htmlspecialchars($r['descripcionCATEGORIA'])?></td>
<td><a class="btn btn-sm btn-primary" href="category_edit.php?id=<?=$r['idCATEGORIA']?>">Editar</a>
<a class="btn btn-sm btn-danger" href="category_delete.php?id=<?=$r['idCATEGORIA']?>" onclick="return confirm('Eliminar?')">Eliminar</a></td></tr><?php endforeach; ?></table></body></html>