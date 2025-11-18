<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; $rows=$pdo->query('SELECT e.*, p.nomPRODUCTO, u.nomUSUARIO FROM entrada e LEFT JOIN producto p ON e.idPRODUCTO=p.idPRODUCTO LEFT JOIN usuario u ON e.idUSUARIO=u.idUSUARIO ORDER BY fechaIngreENTRADA DESC')->fetchAll(); ?>
<!doctype html><html><head><meta charset='utf-8'><title>Entradas</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4"><a href="dashboard.php" class="btn btn-light mb-3">Volver</a><a class="btn btn-success mb-2" href="entrada_create.php">Nueva entrada</a>
<table class="table table-bordered"><tr><th>ID</th><th>Fecha</th><th>Producto</th><th>Cantidad</th><th>Usuario</th></tr>
<?php foreach($rows as $r): ?><tr><td><?=$r['idENTRADA']?></td><td><?=$r['fechaIngreENTRADA']?></td><td><?=htmlspecialchars($r['nomPRODUCTO'])?></td><td><?=$r['cantIngreENTRADA']?></td><td><?=htmlspecialchars($r['nomUSUARIO'])?></td></tr><?php endforeach; ?></table></body></html>