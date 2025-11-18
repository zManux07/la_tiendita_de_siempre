<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; $id=intval($_GET['id']); $r=$pdo->prepare('SELECT * FROM proveedor WHERE idPROVEEDOR=?'); $r->execute([$id]); $row=$r->fetch(); if($_POST){ $n=$_POST['name']; $t=$_POST['tel']; $d=$_POST['dir']; $e=$_POST['email']; $u=$pdo->prepare('UPDATE proveedor SET nomPROVEEDOR=?, telPROVEEDOR=?, direcPROVEEDOR=?, emailPROVEEDOR=? WHERE idPROVEEDOR=?'); $u->execute([$n,$t,$d,$e,$id]); header('Location: provider_list.php'); exit;} ?>
<!doctype html><html><head><meta charset='utf-8'><title>Editar proveedor</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="p-4">
<a href="provider_list.php" class="btn btn-light mb-2">Volver</a>
<form method="post"><input class="form-control mb-2" name="name" value="<?=htmlspecialchars($row['nomPROVEEDOR'])?>" required><input class="form-control mb-2" name="tel" value="<?=$row['telPROVEEDOR']?>"><input class="form-control mb-2" name="dir" value="<?=$row['direcPROVEEDOR']?>"><input class="form-control mb-2" name="email" value="<?=$row['emailPROVEEDOR']?>"><button class="btn btn-primary">Actualizar</button></form></body></html>