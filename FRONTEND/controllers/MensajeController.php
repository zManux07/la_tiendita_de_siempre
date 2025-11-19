<?php

class MensajeController {
    private $mensajeModel;

    public function __construct($mensajeModel) {
        $this->mensajeModel = $mensajeModel;
    }

    public function enviar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = [
                'nombre' => $_POST['nombre'] ?? '',
                'correo' => $_POST['correo'] ?? '',
                'telefono' => $_POST['telefono'] ?? '',
                'mensaje' => $_POST['mensaje'] ?? ''
            ];

            if (empty($datos['nombre']) || empty($datos['correo']) || empty($datos['mensaje'])) {
                $_SESSION['error'] = 'Nombre, correo y mensaje son requeridos';
                header('Location: index.php?route=contacto');
                exit;
            }

            if ($this->mensajeModel->crear($datos)) {
                $_SESSION['success'] = 'Mensaje enviado exitosamente. Nos pondremos en contacto pronto';
            } else {
                $_SESSION['error'] = 'Error al enviar el mensaje';
            }

            header('Location: index.php?route=contacto');
            exit;
        }

        return 'views/frontend/contacto.php';
    }

    public function listar() {
        if (!isset($_SESSION['usuario_rol']) || $_SESSION['usuario_rol'] !== 'admin') {
            header('Location: index.php?route=login');
            exit;
        }

        $mensajes = $this->mensajeModel->obtenerTodos();

        return 'views/admin/mensajes.php';
    }
}
