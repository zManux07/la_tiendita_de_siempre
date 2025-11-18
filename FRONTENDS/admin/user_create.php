<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; if($_POST){ $name=$_POST['name']; $email=$_POST['email']; $pass=password_hash($_POST['password'], PASSWORD_DEFAULT); $rol=$_POST['rol']; $stmt=$pdo->prepare('INSERT INTO usuario (nomUSUARIO,emailUSUARIO,pass,rolUSUARIO) VALUES (?,?,?,?)'); $stmt->execute([$name,$email,$pass,$rol]); header('Location: user_list.php'); exit;} ?>
<!doctype html><html><head><meta charset='utf-8'><title>Nuevo usuario</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4"><a href="user_list.php" class="btn btn-light mb-2">Volver</a><form method="post"><input class="form-control mb-2" name="name" placeholder="Nombre" required><input class="form-control mb-2" name="email" placeholder="Email" type="email" required><input class="form-control mb-2" name="password" placeholder="Contraseña" type="password" required><select class="form-control mb-2" name="rol"><option value="cliente">Cliente</option><option value="admin">Admin</option></select><button class="btn btn-success">Guardar</button></form></body></html>