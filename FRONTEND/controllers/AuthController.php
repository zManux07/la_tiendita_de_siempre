<?php

class AuthController {
    private $usuarioModel;

    public function __construct($usuarioModel) {
        $this->usuarioModel = $usuarioModel;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $pass = $_POST['pass'] ?? '';

            if (empty($email) || empty($pass)) {
                $_SESSION['error'] = 'Email y contraseña son requeridos';
                header('Location: index.php?route=login');
                exit;
            }

            $usuario = $this->usuarioModel->verificarCredenciales($email, $pass);

            if ($usuario) {
                $_SESSION['usuario_id'] = $usuario['idUSUARIO'];
                $_SESSION['usuario_nombre'] = $usuario['nomUSUARIO'];
                $_SESSION['usuario_email'] = $usuario['emailUSUARIO'];
                $_SESSION['usuario_rol'] = $usuario['rolUSUARIO'];
                $_SESSION['success'] = 'Bienvenido ' . $usuario['nomUSUARIO'];

                if ($usuario['rolUSUARIO'] === 'admin') {
                    header('Location: index.php?route=admin/dashboard');
                } else {
                    header('Location: index.php?route=index');
                }
                exit;
            } else {
                $_SESSION['error'] = 'Credenciales inválidas';
                header('Location: index.php?route=login');
                exit;
            }
        }

        return 'views/frontend/login.php';
    }

public function registro() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // 1. Validación de contraseña ANTES de hashear
        if ($_POST['pass'] !== $_POST['pass_confirm']) {
            $_SESSION['error'] = 'Las contraseñas no coinciden';
            header('Location: index.php?route=registro');
            exit;
        }

        // 2. Preparar datos SIN hashear
        $datos = [
            'numdocUSUARIO' => $_POST['numdocUSUARIO'] ?? '',
            'tipodocumenUSUARIO' => $_POST['tipodocumenUSUARIO'] ?? 'CC',
            'nomUSUARIO' => $_POST['nomUSUARIO'] ?? '',
            'direcUSUARIO' => $_POST['direcUSUARIO'] ?? '',
            'telUSUARIO' => $_POST['telUSUARIO'] ?? '',
            'emailUSUARIO' => $_POST['emailUSUARIO'] ?? '',
            'pass' => $_POST['pass'], // ← AQUÍ VA SIN HASH
        ];

        // Validar campos vacíos
        if (empty($datos['nomUSUARIO']) || empty($datos['emailUSUARIO']) || empty($datos['pass'])) {
            $_SESSION['error'] = 'Todos los campos son requeridos';
            header('Location: index.php?route=registro');
            exit;
        }

        // Validar email duplicado
        if ($this->usuarioModel->obtenerPorEmail($datos['emailUSUARIO'])) {
            $_SESSION['error'] = 'El email ya está registrado';
            header('Location: index.php?route=registro');
            exit;
        }

        // Registrar (el modelo hace password_hash correctamente)
        if ($this->usuarioModel->crear($datos)) {
            $_SESSION['success'] = 'Registro exitoso. Inicia sesión';
            header('Location: index.php?route=login');
            exit;
        }

        $_SESSION['error'] = 'Error al registrar. Intenta de nuevo';
        header('Location: index.php?route=registro');
        exit;
    }

    return 'views/frontend/registro.php';
}


    public function logout() {
        session_destroy();
        header('Location: index.php?route=index');
        exit;
    }
}
