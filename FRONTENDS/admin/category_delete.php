<?php
session_start();
if(!isset($_SESSION['user_id']) || !($_SESSION['is_admin'] ?? false)){
    header('Location: ../login.html');
    exit;
}
?>
<?php require '../php/conexion.php'; $id=intval($_GET['id']); $st=$pdo->prepare('DELETE FROM categoria WHERE idCATEGORIA=?'); $st->execute([$id]); header('Location: category_list.php');