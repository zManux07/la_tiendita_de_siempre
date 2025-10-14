<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM usuario WHERE email='$email'";
  $resultado = $conn->query($sql);

  if ($resultado->num_rows > 0) {
    $usuario = $resultado->fetch_assoc();

    if (password_verify($password, $usuario['password'])) {
      echo "<script>alert('Bienvenido, " . $usuario['nombre'] . "!'); window.location='catalogo.html';</script>";
    } else {
      echo "<script>alert('Contraseña incorrecta'); window.history.back();</script>";
    }
  } else {
    echo "<script>alert('Usuario no encontrado'); window.history.back();</script>";
  }
}
?>
