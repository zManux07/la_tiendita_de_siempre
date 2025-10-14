<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST['nombre'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Encriptar la contraseña por seguridad
  $passwordHash = password_hash($password, PASSWORD_DEFAULT);

  $sql = "INSERT INTO usuario (nombre, email, password) VALUES ('$nombre', '$email', '$passwordHash')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('✅ Registro exitoso'); window.location='login.html';</script>";
  } else {
    echo "<script>alert('❌ Error al registrarse'); window.history.back();</script>";
  }
}
?>
