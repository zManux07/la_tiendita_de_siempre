<?php

class EntradaController {
    private $entradaModel;
    private $productoModel;
    private $usuarioModel;

    public function __construct($entradaModel, $productoModel, $usuarioModel) {
        $this->entradaModel = $entradaModel;
        $this->productoModel = $productoModel;
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
                'cantIngreENTRADA' => $_POST['cantIngreENTRADA'] ?? 0,
                'idPRODUCTO' => $_POST['idPRODUCTO'] ?? null,
                'idUSUARIO' => $_SESSION['usuario_id'] ?? null,
                'codigo' => $_POST['codigo'] ?? '',
                'precioCompraUnid' => $_POST['precioCompraUnid'] ?? 0
            ];

            if (empty($datos['cantIngreENTRADA']) || empty($datos['idPRODUCTO'])) {
                $_SESSION['error'] = 'Cantidad e ID de producto son requeridos';
                header('Location: index.php?route=admin/entrada/crear');
                exit;
            }

            if ($this->entradaModel->crear($datos)) {
                $this->productoModel->actualizarStock($datos['idPRODUCTO'], -$datos['cantIngreENTRADA']);
                $_SESSION['success'] = 'Entrada registrada exitosamente';
            } else {
                $_SESSION['error'] = 'Error al registrar la entrada';
            }

            header('Location: index.php?route=admin/dashboard');
            exit;
        }

        $productos = $this->productoModel->obtenerTodos();

        return 'views/admin/crear_entrada.php';
    }
}
