<?php

class CarritoModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function obtenerPorUsuario($idUsuario) {
        $query = "SELECT c.*, p.nomPRODUCTO, p.precioPRODUCTO, p.fotoPRODUCTO
                  FROM carrito c
                  JOIN producto p ON c.idProducto = p.idPRODUCTO
                  WHERE c.idUsuario = ?
                  ORDER BY c.fecha DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar($idUsuario, $idProducto, $cantidad) {
        $query = "INSERT INTO carrito (idUsuario, idProducto, cantidad, fecha)
                  VALUES (?, ?, ?, NOW())";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([$idUsuario, $idProducto, $cantidad]);
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
