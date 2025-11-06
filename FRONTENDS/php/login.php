<?php
// php/login.php - procesa inicio de sesión
session_start();
require 'conexion.php';
if($_SERVER['REQUEST_METHOD'] !== 'POST'){ header('Location: ../login.html'); exit; }
$email = $_POST['email'] ?? '';
$pass = $_POST['password'] ?? '';

// admin shortcut
if($email === 'admin' && $pass === '1234'){
  $_SESSION['user_id'] = 0;
  $_SESSION['user_name'] = 'Administrador';
  $_SESSION['is_admin'] = true;
  header('Location: ../admin/dashboard.php');
  exit;
}

$stmt = $pdo->prepare('SELECT * FROM usuario WHERE emailUSUARIO = ? LIMIT 1');
$stmt->execute([$email]);
$user = $stmt->fetch();
if($user && password_verify($pass, $user['pass'])){
  $_SESSION['user_id'] = $user['idUSUARIO'];
  $_SESSION['user_name'] = $user['nomUSUARIO'];
  $_SESSION['is_admin'] = ($user['rolUSUARIO'] ?? '') === 'admin';
  header('Location: ../index.html');
}else{
  header('Location: ../login.html?error=1');
}
?>