<?php
// php/contacto.php - guarda mensaje en tabla 'entrada' si existe
require 'conexion.php';
if($_SERVER['REQUEST_METHOD'] !== 'POST'){ header('Location: ../contacto.html'); exit; }
$nombre = $_POST['nombre'] ?? '';
$email = $_POST['email'] ?? '';
$mensaje = $_POST['mensaje'] ?? '';
try{
  $pdo->prepare('INSERT INTO entrada (nomENTRADA, emailENTRADA, mensajeENTRADA) VALUES (?,?,?)')->execute([$nombre,$email,$mensaje]);
}catch(Exception $e){
  // ignore if table doesn't exist
}
// redirect back with success flag
header('Location: ../contacto.html?sent=1');
?>