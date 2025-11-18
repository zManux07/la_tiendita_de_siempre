<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; if($_POST){ $n=$_POST['name']; $t=$_POST['tel']; $d=$_POST['dir']; $e=$_POST['email']; $st=$pdo->prepare('INSERT INTO proveedor (nomPROVEEDOR,telPROVEEDOR,direcPROVEEDOR,emailPROVEEDOR) VALUES (?,?,?,?)'); $st->execute([$n,$t,$d,$e]); header('Location: provider_list.php'); exit;} ?>
<!doctype html><html><head><meta charset='utf-8'><title>Nuevo proveedor</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="p-4">
<a href="provider_list.php" class="btn btn-light mb-2">Volver</a>
<form method="post"><input class="form-control mb-2" name="name" placeholder="Nombre" required><input class="form-control mb-2" name="tel" placeholder="Teléfono"><input class="form-control mb-2" name="dir" placeholder="Dirección"><input class="form-control mb-2" name="email" placeholder="Email"><button class="btn btn-success">Guardar</button></form></body></html>