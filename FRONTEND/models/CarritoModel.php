<?php

class CarritoModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function obtenerPorUsuario($idUsuario) {
        $query = "SELECT c.*, 
                p.nomPRODUCTO, 
                p.precioPRODUCTO, 
                p.fotoPRODUCTO,
                p.cantidadenstockPRODUCTO
                FROM carrito c
                JOIN producto p ON c.idProducto = p.idPRODUCTO
                WHERE c.idUsuario = ?
                ORDER BY c.fecha DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar($idUsuario, $idProducto, $cantidad) {

    // consultar stock del producto
    $queryStock = "SELECT cantidadenstockPRODUCTO FROM producto WHERE idPRODUCTO = ?";
    $stmtStock = $this->db->prepare($queryStock);
    $stmtStock->execute([$idProducto]);
    $producto = $stmtStock->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        return false;
    }

    $stock = $producto['cantidadenstockPRODUCTO'];

    // consultar si el producto ya está en el carrito
    $queryCarrito = "SELECT cantidad FROM carrito WHERE idUsuario = ? AND idProducto = ?";
    $stmtCarrito = $this->db->prepare($queryCarrito);
    $stmtCarrito->execute([$idUsuario, $idProducto]);
    $carrito = $stmtCarrito->fetch(PDO::FETCH_ASSOC);

    $cantidadActual = $carrito ? $carrito['cantidad'] : 0;

    // validar stock
    if (($cantidadActual + $cantidad) > $stock) {
        return false;
    }

    if ($carrito) {

        // actualizar cantidad si ya existe
        $query = "UPDATE carrito 
                  SET cantidad = cantidad + ? 
                  WHERE idUsuario = ? AND idProducto = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$cantidad, $idUsuario, $idProducto]);

    } else {

        // insertar nuevo producto en carrito
        $query = "INSERT INTO carrito (idUsuario, idProducto, cantidad, fecha)
                  VALUES (?, ?, ?, NOW())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$idUsuario, $idProducto, $cantidad]);
    }
}

    public function actualizar($idCarrito, $cantidad) {
        $query = "UPDATE carrito SET cantidad = ? WHERE idCarrito = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$cantidad, $idCarrito]);
    }

    public function eliminar($idCarrito) {
        $query = "DELETE FROM carrito WHERE idCarrito = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$idCarrito]);
    }

    public function limpiar($idUsuario) {
        $query = "DELETE FROM carrito WHERE idUsuario = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$idUsuario]);
    }

    public function contar($idUsuario) {
        $query = "SELECT COUNT(*) as total FROM carrito WHERE idUsuario = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idUsuario]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
