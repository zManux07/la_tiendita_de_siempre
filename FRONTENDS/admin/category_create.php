<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; if($_POST){ $n=$_POST['name']; $d=$_POST['desc']; $st=$pdo->prepare('INSERT INTO categoria (nomCATEGORIA, descripcionCATEGORIA) VALUES (?,?)'); $st->execute([$n,$d]); header('Location: category_list.php'); exit;} ?>
<!doctype html><html><head><meta charset='utf-8'><title>Nueva categoría</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="p-4">
<a href="category_list.php" class="btn btn-light mb-2">Volver</a>
<form method="post"><input class="form-control mb-2" name="name" placeholder="Nombre" required><textarea class="form-control mb-2" name="desc" placeholder="Descripción"></textarea><button class="btn btn-success">Guardar</button></form></body></html>