<?php

class DetalleSalidaModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function obtenerPorFactura($idFactura) {
        $query = "SELECT d.*, p.nomPRODUCTO, p.fotoPRODUCTO
                  FROM detallesalida d
                  JOIN producto p ON d.idPRODUCTO = p.idPRODUCTO
                  WHERE d.idFACTURA = ?
                  ORDER BY d.idDETALLE ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$idFactura]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($idFactura, $idProducto, $cantidad, $valorUnitario) {
        $valorTotal = $cantidad * $valorUnitario;

        $query = "INSERT INTO detallesalida
                  (idFACTURA, idPRODUCTO, cantiSalidaDETALLESALIDA, valorunitarioDETALLESALIDA, valorTotalventaDETALLESALIDA)
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([$idFactura, $idProducto, $cantidad, $valorUnitario, $valorTotal]);
    }

    public function obtenerTodos() {
        $query = "SELECT d.*, p.nomPRODUCTO, f.fechaFACTURA
                  FROM detallesalida d
                  JOIN producto p ON d.idPRODUCTO = p.idPRODUCTO
                  JOIN factura f ON d.idFACTURA = f.idFACTURA
                  ORDER BY d.idDETALLE DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
