<?php
// php/register.php - procesa registro
require 'conexion.php';
if($_SERVER['REQUEST_METHOD'] !== 'POST'){ header('Location: ../registro.html'); exit; }
$nombre = trim($_POST['nombre'] ?? '');
$email = trim($_POST['email'] ?? '');
$pass = $_POST['password'] ?? '';
if(!$nombre || !$email || !$pass){ header('Location: ../registro.html?error=1'); exit; }
$hash = password_hash($pass, PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO usuario (nomUSUARIO, emailUSUARIO, pass, rolUSUARIO) VALUES (?,?,?,?)');
try{
  $stmt->execute([$nombre,$email,$hash,'cliente']);
  header('Location: ../login.html?registered=1');
}catch(Exception $e){
  header('Location: ../registro.html?error=1');
}
?>