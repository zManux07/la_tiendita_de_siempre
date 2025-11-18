<?php
// php/cart_model.php
require_once 'conexion.php';
session_start();

class CartModel {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function addToCart($userId, $productId, $cantidad){
        // if cart item exists, update quantity
        $stmt = $this->pdo->prepare('SELECT * FROM carrito WHERE idUsuario = ? AND idProducto = ? LIMIT 1');
        $stmt->execute([$userId, $productId]);
        $item = $stmt->fetch();
        if($item){
            $newQty = $item['cantidad'] + $cantidad;
            $upd = $this->pdo->prepare('UPDATE carrito SET cantidad = ? WHERE idCarrito = ?');
            $upd->execute([$newQty, $item['idCarrito']]);
            return true;
        } else {
            $ins = $this->pdo->prepare('INSERT INTO carrito (idUsuario, idProducto, cantidad) VALUES (?, ?, ?)');
            return $ins->execute([$userId, $productId, $cantidad]);
        }
    }

    public function getCartByUser($userId){
        $stmt = $this->pdo->prepare('SELECT c.idCarrito, c.cantidad, p.idPRODUCTO, p.nomPRODUCTO, p.precioPRODUCTO, p.cantidadenstockPRODUCTO FROM carrito c JOIN producto p ON c.idProducto = p.idPRODUCTO WHERE c.idUsuario = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function updateQuantity($cartId, $cantidad){
        $stmt = $this->pdo->prepare('UPDATE carrito SET cantidad = ? WHERE idCarrito = ?');
        return $stmt->execute([$cantidad, $cartId]);
    }

    public function removeItem($cartId){
        $stmt = $this->pdo->prepare('DELETE FROM carrito WHERE idCarrito = ?');
        return $stmt->execute([$cartId]);
    }

    public function clearCart($userId){
        $stmt = $this->pdo->prepare('DELETE FROM carrito WHERE idUsuario = ?');
        return $stmt->execute([$userId]);
    }
}
?>
