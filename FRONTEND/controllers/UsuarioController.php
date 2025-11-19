<?php

class UsuarioController {
    private $usuarioModel;

    public function __construct($usuarioModel) {
        $this->usuarioModel = $usuarioModel;
        $this->verificarAdmin();
    }

    private function verificarAdmin() {
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
            header('Location: index.php?route=login');
            exit;
        }
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'numdocUSUARIO' => $_POST['numdocUSUARIO'] ?? '',
                'tipodocumenUSUARIO' => $_POST['tipodocumenUSUARIO'] ?? 'CC',
                'nomUSUARIO' => $_POST['nomUSUARIO'] ?? '',
                'direcUSUARIO' => $_POST['direcUSUARIO'] ?? '',
                'telUSUARIO' => $_POST['telUSUARIO'] ?? '',
                'emailUSUARIO' => $_POST['emailUSUARIO'] ?? '',
                'pass' => $_POST['pass'],
                'rolUSUARIO' => $_POST['rolUSUARIO'] ?? 'cliente',
                'cargoUSUARIO' => $_POST['cargoUSUARIO'] ?? null
            ];

            if (empty($datos['nomUSUARIO']) || empty($datos['emailUSUARIO']) || empty($datos['pass'])) {
                $_SESSION['error'] = 'Nombre, email y contraseña son requeridos';
                header('Location: index.php?route=admin/usuario/crear');
                exit;
            }

            if ($this->usuarioModel->obtenerPorEmail($datos['emailUSUARIO'])) {
                $_SESSION['error'] = 'El email ya está registrado';
                header('Location: index.php?route=admin/usuario/crear');
                exit;
            }

            if ($this->usuarioModel->crear($datos)) {
                $_SESSION['success'] = 'Usuario creado exitosamente';
            } else {
                $_SESSION['error'] = 'Error al crear el usuario';
            }

            header('Location: index.php?route=admin/dashboard');
            exit;
        }

        return 'views/admin/crear_usuario.php';
    }
}
