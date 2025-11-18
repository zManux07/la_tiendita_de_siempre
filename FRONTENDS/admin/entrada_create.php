<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; if($_POST){ $prod=intval($_POST['producto']); $cant=intval($_POST['cantidad']); $user=$_SESSION['user_id']; $stmt=$pdo->prepare('INSERT INTO entrada (fechaIngreENTRADA, cantIngreENTRADA, idPRODUCTO, idUSUARIO, codigo, precioCompraUnid) VALUES (CURDATE(),?,?,?,?,?)'); $stmt->execute([ $cant, $prod, $user, '', 0]); $upd=$pdo->prepare('UPDATE producto SET cantidadenstockPRODUCTO = cantidadenstockPRODUCTO + ? WHERE idPRODUCTO=?'); $upd->execute([$cant,$prod]); header('Location: entrada_list.php'); exit;} $prods=$pdo->query('SELECT * FROM producto')->fetchAll(); ?>
<!doctype html><html><head><meta charset='utf-8'><title>Nueva entrada</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4"><a href="entrada_list.php" class="btn btn-light mb-2">Volver</a><form method="post"><select class="form-control mb-2" name="producto"><?php foreach($prods as $p): ?><option value="<?=$p['idPRODUCTO']?>"><?=htmlspecialchars($p['nomPRODUCTO'])?></option><?php endforeach; ?></select><input class="form-control mb-2" name="cantidad" type="number" value="1" min="1"><button class="btn btn-success">Registrar entrada</button></form></body></html>