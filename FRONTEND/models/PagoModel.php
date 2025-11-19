<?php

class PagoModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function obtenerTodos() {
        $query = "SELECT p.*, f.idFACTURA, u.nomUSUARIO
                  FROM pagos p
                  JOIN factura f ON p.idFactura = f.idFACTURA
                  JOIN usuario u ON f.idUSUARIO = u.idUSUARIO
                  ORDER BY p.fecha_pago DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorFactura($idFactura) {
        $query = "SELECT * FROM pagos WHERE idFactura = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idFactura]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($datos) {
        $query = "INSERT INTO pagos
                  (idFactura, metodo_pago, monto, fecha_pago)
                  VALUES (?, ?, ?, NOW())";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $datos['idFactura'],
            $datos['metodo_pago'],
            $datos['monto']
        ]);
    }

    public function contar() {
        $query = "SELECT COUNT(*) as total FROM pagos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function obtenerTotal() {
        $query = "SELECT SUM(monto) as total FROM pagos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
