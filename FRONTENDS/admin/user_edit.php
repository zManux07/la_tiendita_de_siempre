<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; $id=intval($_GET['id']); $r=$pdo->prepare('SELECT * FROM usuario WHERE idUSUARIO=?'); $r->execute([$id]); $u=$r->fetch(); if($_POST){ $name=$_POST['name']; $email=$_POST['email']; $rol=$_POST['rol']; if(!empty($_POST['password'])){ $pass=password_hash($_POST['password'], PASSWORD_DEFAULT); $stmt=$pdo->prepare('UPDATE usuario SET nomUSUARIO=?, emailUSUARIO=?, pass=?, rolUSUARIO=? WHERE idUSUARIO=?'); $stmt->execute([$name,$email,$pass,$rol,$id]); } else { $stmt=$pdo->prepare('UPDATE usuario SET nomUSUARIO=?, emailUSUARIO=?, rolUSUARIO=? WHERE idUSUARIO=?'); $stmt->execute([$name,$email,$rol,$id]); } header('Location: user_list.php'); exit;} ?>
<!doctype html><html><head><meta charset='utf-8'><title>Editar usuario</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4"><a href="user_list.php" class="btn btn-light mb-2">Volver</a><form method="post"><input class="form-control mb-2" name="name" value="<?=htmlspecialchars($u['nomUSUARIO'])?>" required><input class="form-control mb-2" name="email" value="<?=$u['emailUSUARIO']?>" type="email" required><input class="form-control mb-2" name="password" placeholder="Nueva contraseña (opcional)" type="password"><select class="form-control mb-2" name="rol"><option value="cliente" <?=$u['rolUSUARIO']=='cliente'?'selected':''?>>Cliente</option><option value="admin" <?=$u['rolUSUARIO']=='admin'?'selected':''?>>Admin</option></select><button class="btn btn-primary">Actualizar</button></form></body></html>