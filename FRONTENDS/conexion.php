<?php
$servername = "localhost";
$username = "root"; // cámbialo si usas otro usuario
$password = ""; // pon tu contraseña si tienes
$database = "latienditadesiempre"; // cambia al nombre de tu BD

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
  die("❌ Error de conexión: " . $conn->connect_error);
}
?>
