<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; $rows=$pdo->query('SELECT * FROM mensajes_contacto ORDER BY fecha_envio DESC')->fetchAll(); ?>
<!doctype html><html><head><meta charset='utf-8'><title>Mensajes</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4"><a href="dashboard.php" class="btn btn-light mb-3">Volver</a><table class="table table-bordered"><tr><th>ID</th><th>Nombre</th><th>Email</th><th>Tel</th><th>Mensaje</th><th>Fecha</th></tr>
<?php foreach($rows as $r): ?><tr><td><?=$r['id_mensaje']?></td><td><?=htmlspecialchars($r['nombre'])?></td><td><?=htmlspecialchars($r['correo'])?></td><td><?=$r['telefono']?></td><td><?=nl2br(htmlspecialchars($r['mensaje']))?></td><td><?=$r['fecha_envio']?></td></tr><?php endforeach; ?></table></body></html>