<?php

class EntradaModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function obtenerTodas() {
        $query = "SELECT e.*, p.nomPRODUCTO, u.nomUSUARIO
                  FROM entrada e
                  JOIN producto p ON e.idPRODUCTO = p.idPRODUCTO
                  JOIN usuario u ON e.idUSUARIO = u.idUSUARIO
                  ORDER BY e.fechaIngreENTRADA DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT e.*, p.nomPRODUCTO, u.nomUSUARIO
                  FROM entrada e
                  JOIN producto p ON e.idPRODUCTO = p.idPRODUCTO
                  JOIN usuario u ON e.idUSUARIO = u.idUSUARIO
                  WHERE e.idENTRADA = ?";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($datos) {
        $query = "INSERT INTO entrada
                  (fechaIngreENTRADA, cantIngreENTRADA, idPRODUCTO, idUSUARIO, codigo, precioCompraUnid)
                  VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            date('Y-m-d'),
            $datos['cantIngreENTRADA'],
            $datos['idPRODUCTO'],
            $datos['idUSUARIO'],
            $datos['codigo'],
            $datos['precioCompraUnid']
        ]);
    }

    public function contar() {
        $query = "SELECT COUNT(*) as total FROM entrada";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function obtenerUltimasEntradas($limit = 10) {
        $query = "SELECT e.*, p.nomPRODUCTO, u.nomUSUARIO
                  FROM entrada e
                  JOIN producto p ON e.idPRODUCTO = p.idPRODUCTO
                  JOIN usuario u ON e.idUSUARIO = u.idUSUARIO
                  ORDER BY e.fechaIngreENTRADA DESC
                  LIMIT ?";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
