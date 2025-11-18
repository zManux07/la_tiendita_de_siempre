<?php
require '../php/conexion.php';
if($_POST){
  $name=$_POST['name']; $marca=$_POST['marca']; $precio=$_POST['precio'];
  $stock=$_POST['stock']; $cat=$_POST['categoria']; $prov=$_POST['proveedor'];
  $unidad='Unidad';
  $foto = null;
  if(!empty($_FILES['foto']['name'])){
    $foto = basename($_FILES['foto']['name']);
    move_uploaded_file($_FILES['foto']['tmp_name'], "../img/".$foto);
  }
  $stmt=$pdo->prepare("INSERT INTO producto (nomPRODUCTO, marcaPRODUCTO, precioPRODUCTO, cantidadenstockPRODUCTO, fechaingrePRODUCTO, unidadMedidaPRODUCTO, fotoPRODUCTO, idCATEGORIA, idPROVEEDOR)
  VALUES (?,?,?,?,CURDATE(),?,?,?,?)");
  $stmt->execute([$name,$marca,$precio,$stock,$unidad,$foto,$cat,$prov]);
  header("Location: product_list.php"); exit;
}
$cats=$pdo->query("SELECT * FROM categoria")->fetchAll();
$provs=$pdo->query("SELECT * FROM proveedor")->fetchAll();
?>
<!doctype html><html><head><meta charset='utf-8'><title>Crear producto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4">
<h3>Nuevo producto</h3>
<form method="post" enctype="multipart/form-data">
<input class="form-control mb-2" name="name" placeholder="Nombre" required>
<input class="form-control mb-2" name="marca" placeholder="Marca" required>
<input class="form-control mb-2" name="precio" type="number" placeholder="Precio" required>
<input class="form-control mb-2" name="stock" type="number" placeholder="Stock" required>
<label>Categoría</label><select class="form-control mb-2" name="categoria">
<?php foreach($cats as $c): ?><option value="<?=$c['idCATEGORIA']?>"><?=$c['nomCATEGORIA']?></option><?php endforeach; ?>
</select>
<label>Proveedor</label><select class="form-control mb-2" name="proveedor">
<?php foreach($provs as $p): ?><option value="<?=$p['idPROVEEDOR']?>"><?=$p['nomPROVEEDOR']?></option><?php endforeach; ?>
</select>
<label>Foto</label>
<input type="file" name="foto" class="form-control mb-2">
<button class="btn btn-success">Guardar</button>
</form>
</body></html>