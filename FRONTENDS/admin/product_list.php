<?php
require '../php/conexion.php';
$rows = $pdo->query("SELECT * FROM producto")->fetchAll();
?>
<!doctype html><html><head><meta charset='utf-8'><title>Productos</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4">
<a href="product_create.php" class="btn btn-success mb-2">Nuevo producto</a>
<table class="table table-bordered"><tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th><th>Foto</th><th>Acciones</th></tr>
<?php foreach($rows as $r): ?>
<tr>
<td><?=$r['idPRODUCTO']?></td>
<td><?=htmlspecialchars($r['nomPRODUCTO'])?></td>
<td><?=$r['precioPRODUCTO']?></td>
<td><?=$r['cantidadenstockPRODUCTO']?></td>
<td><img src="../img/<?=$r['fotoPRODUCTO']?>" width="50"></td>
<td>
<a class="btn btn-primary btn-sm" href="product_edit.php?id=<?=$r['idPRODUCTO']?>">Editar</a>
<a class="btn btn-danger btn-sm" href="product_delete.php?id=<?=$r['idPRODUCTO']?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
</td></tr>
<?php endforeach; ?>
</table>
</body></html>