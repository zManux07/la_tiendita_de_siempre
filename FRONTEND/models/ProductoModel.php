<?php

class ProductoModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function obtenerTodos() {
        $query = "SELECT p.*, c.nomCATEGORIA, pr.nomPROVEEDOR
                  FROM producto p
                  LEFT JOIN categoria c ON p.idCATEGORIA = c.idCATEGORIA
                  LEFT JOIN proveedor pr ON p.idPROVEEDOR = pr.idPROVEEDOR
                  ORDER BY p.idPRODUCTO DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerDestacados() {
    $query = "SELECT p.*, c.nomCATEGORIA, pr.nomPROVEEDOR
              FROM producto p
              LEFT JOIN categoria c ON p.idCATEGORIA = c.idCATEGORIA
              LEFT JOIN proveedor pr ON p.idPROVEEDOR = pr.idPROVEEDOR
              WHERE p.destacado = 1
              ORDER BY p.idPRODUCTO DESC";

    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function obtenerPorId($id) {
        $query = "SELECT p.*, c.nomCATEGORIA, pr.nomPROVEEDOR
                  FROM producto p
                  LEFT JOIN categoria c ON p.idCATEGORIA = c.idCATEGORIA
                  LEFT JOIN proveedor pr ON p.idPROVEEDOR = pr.idPROVEEDOR
                  WHERE p.idPRODUCTO = ?";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorCategoria($idCategoria) {
        $query = "SELECT p.*, c.nomCATEGORIA
                  FROM producto p
                  LEFT JOIN categoria c ON p.idCATEGORIA = c.idCATEGORIA
                  WHERE p.idCATEGORIA = ?
                  ORDER BY p.nomPRODUCTO ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute([$idCategoria]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($datos) {
        $query = "INSERT INTO producto
                  (nomPRODUCTO, marcaPRODUCTO, precioPRODUCTO, cantidadenstockPRODUCTO,
                   fechaingrePRODUCTO, unidadMedidaPRODUCTO, fotoPRODUCTO, idCATEGORIA, idPROVEEDOR)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $datos['nomPRODUCTO'],
            $datos['marcaPRODUCTO'],
            $datos['precioPRODUCTO'],
            $datos['cantidadenstockPRODUCTO'],
            date('Y-m-d'),
            $datos['unidadMedidaPRODUCTO'],
            $datos['fotoPRODUCTO'] ?? null,
            $datos['idCATEGORIA'],
            $datos['idPROVEEDOR']
        ]);
    }

    public function actualizarStock($idProducto, $cantidad) {
        $query = "UPDATE producto 
            SET cantidadenstockPRODUCTO = cantidadenstockPRODUCTO + ?
            WHERE idPRODUCTO = ?";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([$cantidad, $idProducto]);
}


    public function buscar($termino) {
        $query = "SELECT p.*, c.nomCATEGORIA
                  FROM producto p
                  LEFT JOIN categoria c ON p.idCATEGORIA = c.idCATEGORIA
                  WHERE p.nomPRODUCTO LIKE ? OR p.marcaPRODUCTO LIKE ?
                  ORDER BY p.nomPRODUCTO ASC";

        $stmt = $this->db->prepare($query);
        $termino = '%' . $termino . '%';
        $stmt->execute([$termino, $termino]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
