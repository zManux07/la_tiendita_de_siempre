<?php

class CategoriaModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function obtenerTodas() {
        $query = "SELECT * FROM categoria ORDER BY nomCATEGORIA ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM categoria WHERE idCATEGORIA = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($datos) {
        $query = "INSERT INTO categoria (nomCATEGORIA, descripcionCATEGORIA)
                  VALUES (?, ?)";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $datos['nomCATEGORIA'],
            $datos['descripcionCATEGORIA']
        ]);
    }

    public function contar() {
        $query = "SELECT COUNT(*) as total FROM categoria";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
public function actualizar($id, $datos) {
    $query = "UPDATE categoria 
              SET nomCATEGORIA = ?, descripcionCATEGORIA = ?
              WHERE idCATEGORIA = ?";

    $stmt = $this->db->prepare($query);
    return $stmt->execute([
        $datos['nomCATEGORIA'],
        $datos['descripcionCATEGORIA'],
        $id
    ]);
}

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM categoria WHERE idCATEGORIA = ?");
        return $stmt->execute([$id]);
    }
}
