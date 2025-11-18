
<?php
require 'php/conexion.php';
$stmt = $pdo->query("SELECT * FROM producto");
$productos = $stmt->fetchAll();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Catálogo - La Tiendita de Siempre</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<div class="container mt-5 pt-4">
  <h2 class="mb-4">Catálogo de Productos</h2>
  <div class="row">
    <?php foreach($productos as $p): ?>
    <div class="col-md-4 mb-4">
      <div class="card h-100 text-center p-3">
        <img src="img/<?= htmlspecialchars($p['fotoPRODUCTO']) ?>" class="card-img-top" style="height:160px;object-fit:contain;">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($p['nomPRODUCTO']) ?></h5>
          <p class="card-text text-primary fw-bold">$<?= number_format($p['precioPRODUCTO']) ?></p>
          <button class="btn btn-outline-primary btn-add-cart" data-product-id="<?= $p['idPRODUCTO'] ?>">Añadir al carrito</button>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.btn-add-cart').forEach(function(btn){
    btn.addEventListener('click', function(){
      const pid = this.getAttribute('data-product-id');
      fetch('php/cart_controller.php?action=add', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'product_id=' + encodeURIComponent(pid) + '&quantity=1'
      }).then(r=>r.json()).then(data=>{
        if(data.error){
          alert(data.error);
          if(data.error.toLowerCase().includes('iniciar sesión')) window.location.href='login.html';
        } else if(data.ok){
          alert('Producto añadido al carrito');
        } else { alert('Error'); }
      });
    });
  });
});
</script>

</body>
</html>
