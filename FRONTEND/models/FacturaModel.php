<?php

class FacturaModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function obtenerTodas() {
        $query = "SELECT f.*, u.nomUSUARIO, u.emailUSUARIO
                  FROM factura f
                  JOIN usuario u ON f.idUSUARIO = u.idUSUARIO
                  ORDER BY f.fechaFACTURA DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorUsuario($idUsuario) {
        $query = "SELECT f.*, u.nomUSUARIO
                  FROM factura f
                  JOIN usuario u ON f.idUSUARIO = u.idUSUARIO
                  WHERE f.idUSUARIO = ?
                  ORDER BY f.fechaFACTURA DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT f.*, u.nomUSUARIO, u.emailUSUARIO, u.telUSUARIO, u.direcUSUARIO
                  FROM factura f
                  JOIN usuario u ON f.idUSUARIO = u.idUSUARIO
                  WHERE f.idFACTURA = ?";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($idUsuario, $total) {
        $query = "INSERT INTO factura (fechaFACTURA, idUSUARIO, totalFACTURA)
                  VALUES (NOW(), ?, ?)";

        $stmt = $this->db->prepare($query);
        if ($stmt->execute([$idUsuario, $total])) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function contar() {
        $query = "SELECT COUNT(*) as total FROM factura";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function obtenerTotal() {
        $query = "SELECT SUM(totalFACTURA) as total FROM factura";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
