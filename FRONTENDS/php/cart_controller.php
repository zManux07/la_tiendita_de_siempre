<?php
// php/cart_controller.php
require 'conexion.php';
require 'cart_model.php';
session_start();

$model = new CartModel($pdo);

$action = $_REQUEST['action'] ?? '';

$userId = $_SESSION['user_id'] ?? null;
if(!$userId && $action !== 'view'){ // require login to manipulate cart
    http_response_code(401);
    echo json_encode(['error' => 'Debe iniciar sesión para usar el carrito.']);
    exit;
}

header('Content-Type: application/json');

try {
    if($action === 'add'){
        $productId = intval($_POST['product_id'] ?? 0);
        $qty = max(1, intval($_POST['quantity'] ?? 1));
        if($productId <= 0){ throw new Exception('Producto inválido'); }
        $ok = $model->addToCart($userId, $productId, $qty);
        echo json_encode(['ok' => $ok]);
    } elseif($action === 'view'){
        if(!$userId){ echo json_encode(['items'=>[]]); exit; }
        $items = $model->getCartByUser($userId);
        echo json_encode(['items'=>$items]);
    } elseif($action === 'update'){
        $cartId = intval($_POST['cart_id'] ?? 0);
        $qty = max(1, intval($_POST['quantity'] ?? 1));
        $ok = $model->updateQuantity($cartId, $qty);
        echo json_encode(['ok'=>$ok]);
    } elseif($action === 'remove'){
        $cartId = intval($_POST['cart_id'] ?? 0);
        $ok = $model->removeItem($cartId);
        echo json_encode(['ok'=>$ok]);
    } elseif($action === 'checkout'){
        // create factura and detalles, reduce stock, clear cart
        if(!$userId) throw new Exception('No autorizado');
        $pdo->beginTransaction();
        // calculate total
        $items = $model->getCartByUser($userId);
        $total = 0;
        foreach($items as $it) $total += $it['precioPRODUCTO'] * $it['cantidad'];
        // insert factura
        $insFact = $pdo->prepare('INSERT INTO factura (fechaFACTURA, idUSUARIO, totalFACTURA) VALUES (CURDATE(), ?, ?)');
        $insFact->execute([$userId, $total]);
        $factId = $pdo->lastInsertId();
        $insDet = $pdo->prepare('INSERT INTO detallesalida (idFACTURA, idPRODUCTO, cantiSalidaDETALLESALIDA, valorunitarioDETALLESALIDA, valorTotalventaDETALLESALIDA) VALUES (?, ?, ?, ?, ?)');
        $updStock = $pdo->prepare('UPDATE producto SET cantidadenstockPRODUCTO = cantidadenstockPRODUCTO - ? WHERE idPRODUCTO = ?');
        foreach($items as $it){
            $subtotal = $it['precioPRODUCTO'] * $it['cantidad'];
            $insDet->execute([$factId, $it['idPRODUCTO'], $it['cantidad'], $it['precioPRODUCTO'], $subtotal]);
            $updStock->execute([$it['cantidad'], $it['idPRODUCTO']]);
        }
        $model->clearCart($userId);
        $pdo->commit();
        echo json_encode(['ok'=>true, 'factura_id'=>$factId]);
    } else {
        echo json_encode(['error'=>'Acción no válida']);
    }
} catch(Exception $e){
    if($pdo->inTransaction()) $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error'=>$e->getMessage()]);
}
?>
