<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<!doctype html>
<html lang="es">
<head><meta charset="utf-8"><title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4">
<h2>Panel de administración</h2>
<p>Bienvenido, <?=$_SESSION['user_name']?></p>
<div class="row mt-4">
  <div class="col-md-3"><a class="btn btn-outline-primary w-100" href="product_list.php">Productos</a></div>
  <div class="col-md-3"><a class="btn btn-outline-secondary w-100" href="category_list.php">Categorías</a></div>
  <div class="col-md-3"><a class="btn btn-outline-success w-100" href="provider_list.php">Proveedores</a></div>
  <div class="col-md-3"><a class="btn btn-outline-info w-100" href="user_list.php">Usuarios</a></div>
</div>
<div class="row mt-3">
  <div class="col-md-3"><a class="btn btn-outline-dark w-100" href="entrada_list.php">Entradas</a></div>
  <div class="col-md-3"><a class="btn btn-outline-warning w-100" href="factura_list.php">Facturas</a></div>
  <div class="col-md-3"><a class="btn btn-outline-danger w-100" href="mensajes_list.php">Mensajes</a></div>
  <div class="col-md-3"><a class="btn btn-light w-100" href="../index.html">Ver sitio</a></div>
</div>
<hr>
<a href="../php/cerrar_sesion.php" class="btn btn-sm btn-outline-danger">Cerrar sesión</a>
</body></html>