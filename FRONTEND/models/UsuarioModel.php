<?php

class UsuarioModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function obtenerTodos() {
        $query = "SELECT idUSUARIO, numdocUSUARIO, tipodocumenUSUARIO, nomUSUARIO,
                         direcUSUARIO, telUSUARIO, emailUSUARIO, rolUSUARIO, cargoUSUARIO
                  FROM usuario ORDER BY nomUSUARIO ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $query = "SELECT idUSUARIO, numdocUSUARIO, tipodocumenUSUARIO, nomUSUARIO,
                         direcUSUARIO, telUSUARIO, emailUSUARIO, rolUSUARIO, cargoUSUARIO
                  FROM usuario WHERE idUSUARIO = ?";
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
            $datos['rolUSUARIO'] ?? 'cliente',
            $datos['cargoUSUARIO'] ?? null
        ]);
    }

    public function verificarCredenciales($email, $pass) {
        $usuario = $this->obtenerPorEmail($email);

        if (!$usuario) {
            return false;
        }

        if (password_verify($pass, $usuario['pass'])) {
            return $usuario;
        }

        return false;
    }

    public function contar() {
        $query = "SELECT COUNT(*) as total FROM usuario";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
