<?php

class ProveedorModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function obtenerTodos() {
        $query = "SELECT * FROM proveedor ORDER BY nomPROVEEDOR ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM proveedor WHERE idPROVEEDOR = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($datos) {
        $query = "INSERT INTO proveedor
                  (nomPROVEEDOR, telPROVEEDOR, direcPROVEEDOR, emailPROVEEDOR)
                  VALUES (?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $datos['nomPROVEEDOR'],
            $datos['telPROVEEDOR'],
            $datos['direcPROVEEDOR'],
            $datos['emailPROVEEDOR']
        ]);
    }

    public function contar() {
        $query = "SELECT COUNT(*) as total FROM proveedor";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
