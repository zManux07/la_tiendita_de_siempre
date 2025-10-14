<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nombre = $_POST['nombre'];
  $correo = $_POST['correo'];
  $mensaje = $_POST['mensaje'];

  $sql = "INSERT INTO mensajes_contacto (nombre, correo, mensaje, fecha_envio) VALUES ('$nombre', '$correo', '$mensaje', NOW())";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Mensaje enviado correctamente ✅'); window.location='contacto.html';</script>";
  } else {
    echo "<script>alert('Error al enviar el mensaje ❌'); window.history.back();</script>";
  }
}
?>
