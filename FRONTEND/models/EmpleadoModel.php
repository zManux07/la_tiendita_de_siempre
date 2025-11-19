<?php

class EmpleadoModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function obtenerTodos() {
        $query = "SELECT * FROM empleados ORDER BY nombre ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM empleados WHERE id_empleado = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($datos) {
        $query = "INSERT INTO empleados
                  (nombre, cargo, correo, telefono, fecha_ingreso)
                  VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $datos['nombre'],
            $datos['cargo'],
            $datos['correo'],
            $datos['telefono'],
            $datos['fecha_ingreso']
        ]);
    }

    public function actualizar($id, $datos) {
        $query = "UPDATE empleados SET
                    nombre = ?,
                    cargo = ?,
                    correo = ?,
                    telefono = ?,
                    fecha_ingreso = ?
                  WHERE id_empleado = ?";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $datos['nombre'],
            $datos['cargo'],
            $datos['correo'],
            $datos['telefono'],
            $datos['fecha_ingreso'],
            $id
        ]);
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM empleados WHERE id_empleado = ?");
        return $stmt->execute([$id]);
    }

    public function contar() {
        return $this->db->query("SELECT COUNT(*) FROM empleados")->fetchColumn();
    }
}

