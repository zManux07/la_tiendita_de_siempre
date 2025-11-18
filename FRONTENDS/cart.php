<?php
// cart.php - muestra el carrito del usuario
session_start();
require 'php/conexion.php';
require 'php/cart_model.php';
if(!isset($_SESSION['user_id'])){ header('Location: login.html'); exit; }
$userId = $_SESSION['user_id'];
$model = new CartModel($pdo);
$items = $model->getCartByUser($userId);
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Carrito - La Tiendita de Siempre</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<div class="container py-4">
  <h3>Tu carrito</h3>
  <?php if(empty($items)): ?>
    <p>Tu carrito está vacío. <a href="catalogo.html">Ir al catálogo</a></p>
  <?php else: ?>
    <table class="table">
      <thead><tr><th>Producto</th><th>Precio</th><th>Cantidad</th><th>Subtotal</th><th></th></tr></thead>
      <tbody>
        <?php $total=0; foreach($items as $it): $sub = $it['precioPRODUCTO']*$it['cantidad']; $total+=$sub; ?>
          <tr>
            <td><?=htmlspecialchars($it['nomPRODUCTO'])?></td>
            <td>$<?=number_format($it['precioPRODUCTO'])?></td>
            <td>
              <form method="post" action="php/cart_controller.php?action=update" style="display:inline;">
                <input type="hidden" name="cart_id" value="<?=$it['idCarrito']?>">
                <input type="number" name="quantity" value="<?=$it['cantidad']?>" min="1" style="width:70px;">
                <button class="btn btn-sm btn-primary" type="submit">Actualizar</button>
              </form>
            </td>
            <td>$<?=number_format($sub)?></td>
            <td>
              <form method="post" action="php/cart_controller.php?action=remove">
                <input type="hidden" name="cart_id" value="<?=$it['idCarrito']?>">
                <button class="btn btn-sm btn-danger">Eliminar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr><th colspan="3">Total</th><th>$<?=number_format($total)?></th><th></th></tr>
      </tfoot>
    </table>
    <form method="post" action="php/cart_controller.php?action=checkout">
      <button class="btn btn-success">Finalizar compra</button>
    </form>
  <?php endif; ?>
</div>
</body>
</html>
