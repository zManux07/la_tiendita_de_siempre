<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; $rows=$pdo->query('SELECT f.*, u.nomUSUARIO FROM factura f LEFT JOIN usuario u ON f.idUSUARIO=u.idUSUARIO ORDER BY fechaFACTURA DESC')->fetchAll(); ?>
<!doctype html><html><head><meta charset='utf-8'><title>Facturas</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4"><a href="dashboard.php" class="btn btn-light mb-3">Volver</a><table class="table table-bordered"><tr><th>ID</th><th>Fecha</th><th>Usuario</th><th>Total</th><th>Acciones</th></tr>
<?php foreach($rows as $r): ?><tr><td><?=$r['idFACTURA']?></td><td><?=$r['fechaFACTURA']?></td><td><?=htmlspecialchars($r['nomUSUARIO'])?></td><td><?=$r['totalFACTURA']?></td><td><a class="btn btn-sm btn-primary" href="factura_view.php?id=<?=$r['idFACTURA']?>">Ver</a></td></tr><?php endforeach; ?></table></body></html>