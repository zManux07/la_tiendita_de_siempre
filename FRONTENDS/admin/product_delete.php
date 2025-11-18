<?php
require '../php/conexion.php';
$id=intval($_GET['id']);
$stmt=$pdo->prepare("DELETE FROM producto WHERE idPRODUCTO=?");
$stmt->execute([$id]);
header("Location: product_list.php");
?>