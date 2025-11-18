<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; $id=intval($_GET['id']); $f=$pdo->prepare('SELECT f.*, u.nomUSUARIO FROM factura f LEFT JOIN usuario u ON f.idUSUARIO=u.idUSUARIO WHERE idFACTURA=?'); $f->execute([$id]); $fact=$f->fetch(); $det=$pdo->prepare('SELECT d.*, p.nomPRODUCTO FROM detallesalida d LEFT JOIN producto p ON d.idPRODUCTO=p.idPRODUCTO WHERE idFACTURA=?'); $det->execute([$id]); $items=$det->fetchAll(); ?>
<!doctype html><html><head><meta charset='utf-8'><title>Factura <?=$id?></title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4"><a href="factura_list.php" class="btn btn-light mb-2">Volver</a>
<h3>Factura #<?=$fact['idFACTURA']?></h3><p>Cliente: <?=htmlspecialchars($fact['nomUSUARIO'])?> | Fecha: <?=$fact['fechaFACTURA']?></p>
<table class="table"><tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Subtotal</th></tr>
<?php $total=0; foreach($items as $it): $sub=$it['cantiSalidaDETALLESALIDA']*$it['valorunitarioDETALLESALIDA']; $total+=$sub; ?><tr><td><?=htmlspecialchars($it['nomPRODUCTO'])?></td><td><?=$it['cantiSalidaDETALLESALIDA']?></td><td><?=$it['valorunitarioDETALLESALIDA']?></td><td><?=$sub?></td></tr><?php endforeach; ?>
<tr><th colspan="3">Total</th><th><?=$total?></th></tr></table></body></html>