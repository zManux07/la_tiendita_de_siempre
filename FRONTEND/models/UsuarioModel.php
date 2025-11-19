<?php

class UsuarioModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function obtenerTodos() {
        $query = "SELECT * FROM usuario ORDER BY nomUSUARIO ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT * FROM usuario WHERE idUSUARIO = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function obtenerPorEmail($email) {
        $query = "SELECT * FROM usuario WHERE emailUSUARIO = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($datos) {
        $query = "INSERT INTO usuario
                  (numdocUSUARIO, tipodocumenUSUARIO, nomUSUARIO, direcUSUARIO,
                   telUSUARIO, emailUSUARIO, pass, rolUSUARIO, cargoUSUARIO)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $datos['numdocUSUARIO'],
            $datos['tipodocumenUSUARIO'],
            $datos['nomUSUARIO'],
            $datos['direcUSUARIO'],
            $datos['telUSUARIO'],
            $datos['emailUSUARIO'],
            password_hash($datos['pass'], PASSWORD_BCRYPT),
            $datos['rolUSUARIO'],
            $datos['cargoUSUARIO']
        ]);
    }

    public function actualizar($id, $datos) {
        $query = "UPDATE usuario SET
                    numdocUSUARIO = ?,
                    tipodocumenUSUARIO = ?,
                    nomUSUARIO = ?,
                    direcUSUARIO = ?,
                    telUSUARIO = ?,
                    emailUSUARIO = ?,
                    rolUSUARIO = ?,
                    cargoUSUARIO = ?
                  WHERE idUSUARIO = ?";

        $stmt = $this->db->prepare($query);

        return $stmt->execute([
            $datos['numdocUSUARIO'],
            $datos['tipodocumenUSUARIO'],
            $datos['nomUSUARIO'],
            $datos['direcUSUARIO'],
            $datos['telUSUARIO'],
            $datos['emailUSUARIO'],
            $datos['rolUSUARIO'],
            $datos['cargoUSUARIO'],
            $id
        ]);
    }

    public function eliminar($id) {
        $stmt = $this->db->prepare("DELETE FROM usuario WHERE idUSUARIO = ?");
        return $stmt->execute([$id]);
    }

    public function contar() {
        $query = "SELECT COUNT(*) FROM usuario";
        return $this->db->query($query)->fetchColumn();
    }
}

