<?php
require '../php/conexion.php';
$id=intval($_GET['id']);
$prod=$pdo->prepare("SELECT * FROM producto WHERE idPRODUCTO=?");
$prod->execute([$id]);
$prod=$prod->fetch();
if(!$prod){ echo "No existe"; exit; }

if($_POST){
  $name=$_POST['name']; $marca=$_POST['marca']; $precio=$_POST['precio'];
  $stock=$_POST['stock']; $cat=$_POST['categoria']; $prov=$_POST['proveedor'];
  $foto=$prod['fotoPRODUCTO'];
  if(!empty($_FILES['foto']['name'])){
    $foto = basename($_FILES['foto']['name']);
    move_uploaded_file($_FILES['foto']['tmp_name'], "../img/".$foto);
  }
  $stmt=$pdo->prepare("UPDATE producto SET nomPRODUCTO=?, marcaPRODUCTO=?, precioPRODUCTO=?, cantidadenstockPRODUCTO=?, idCATEGORIA=?, idPROVEEDOR=?, fotoPRODUCTO=? WHERE idPRODUCTO=?");
  $stmt->execute([$name,$marca,$precio,$stock,$cat,$prov,$foto,$id]);
  header("Location: product_list.php"); exit;
}
$cats=$pdo->query("SELECT * FROM categoria")->fetchAll();
$provs=$pdo->query("SELECT * FROM proveedor")->fetchAll();
?>
<!doctype html><html><head><meta charset='utf-8'><title>Editar producto</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="p-4">
<h3>Editar producto</h3>
<form method="post" enctype="multipart/form-data">
<input class="form-control mb-2" name="name" value="<?=$prod['nomPRODUCTO']?>" required>
<input class="form-control mb-2" name="marca" value="<?=$prod['marcaPRODUCTO']?>" required>
<input class="form-control mb-2" name="precio" type="number" value="<?=$prod['precioPRODUCTO']?>" required>
<input class="form-control mb-2" name="stock" type="number" value="<?=$prod['cantidadenstockPRODUCTO']?>" required>

<label>Categoría</label><select class="form-control mb-2" name="categoria">
<?php foreach($cats as $c): ?><option value="<?=$c['idCATEGORIA']?>" <?=$c['idCATEGORIA']==$prod['idCATEGORIA']?'selected':''?>><?=$c['nomCATEGORIA']?></option><?php endforeach; ?>
</select>

<label>Proveedor</label><select class="form-control mb-2" name="proveedor">
<?php foreach($provs as $p): ?><option value="<?=$p['idPROVEEDOR']?>" <?=$p['idPROVEEDOR']==$prod['idPROVEEDOR']?'selected':''?>><?=$p['nomPROVEEDOR']?></option><?php endforeach; ?>
</select>

<label>Foto actual:</label><br>
<img src="../img/<?=$prod['fotoPRODUCTO']?>" width="80"><br><br>
<label>Nueva foto:</label>
<input type="file" name="foto" class="form-control mb-2">

<button class="btn btn-primary">Actualizar</button>
</form>
</body></html>