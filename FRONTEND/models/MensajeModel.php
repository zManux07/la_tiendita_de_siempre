<?php

class MensajeModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function obtenerTodos() {
        $query = "SELECT * FROM mensajes_contacto ORDER BY fecha_envio DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM mensajes_contacto WHERE id_mensaje = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($datos) {
        $query = "INSERT INTO mensajes_contacto
                  (nombre, correo, telefono, mensaje, fecha_envio)
                  VALUES (?, ?, ?, ?, NOW())";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $datos['nombre'],
            $datos['correo'],
            $datos['telefono'],
            $datos['mensaje']
        ]);
    }

    public function contar() {
        $query = "SELECT COUNT(*) as total FROM mensajes_contacto";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

public function obtenerRecientes($limit = 5) {
    $limit = (int)$limit; // Convertimos a entero por seguridad

    $query = "SELECT * FROM mensajes_contacto
              ORDER BY fecha_envio DESC
              LIMIT $limit";

    $stmt = $this->db->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
