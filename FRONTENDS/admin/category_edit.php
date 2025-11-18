<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; $id=intval($_GET['id']); $r=$pdo->prepare('SELECT * FROM categoria WHERE idCATEGORIA=?'); $r->execute([$id]); $row=$r->fetch(); if($_POST){ $n=$_POST['name']; $d=$_POST['desc']; $u=$pdo->prepare('UPDATE categoria SET nomCATEGORIA=?, descripcionCATEGORIA=? WHERE idCATEGORIA=?'); $u->execute([$n,$d,$id]); header('Location: category_list.php'); exit;} ?>
<!doctype html><html><head><meta charset='utf-8'><title>Editar categoría</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="p-4">
<a href="category_list.php" class="btn btn-light mb-2">Volver</a>
<form method="post"><input class="form-control mb-2" name="name" value="<?=htmlspecialchars($row['nomCATEGORIA'])?>" required><textarea class="form-control mb-2" name="desc"><?=htmlspecialchars($row['descripcionCATEGORIA'])?></textarea><button class="btn btn-primary">Actualizar</button></form></body></html>