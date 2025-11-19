<?php

class PagoController {
    private $pagoModel;
    private $facturaModel;

    public function __construct($pagoModel, $facturaModel) {
        $this->pagoModel = $pagoModel;
        $this->facturaModel = $facturaModel;
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
                'idFactura' => $_POST['idFactura'] ?? null,
                'metodo_pago' => $_POST['metodo_pago'] ?? '',
                'monto' => $_POST['monto'] ?? 0
            ];

            if (empty($datos['idFactura']) || empty($datos['metodo_pago']) || empty($datos['monto'])) {
                $_SESSION['error'] = 'Todos los campos son requeridos';
                header('Location: index.php?route=admin/pago/crear');
                exit;
            }

            if ($this->pagoModel->crear($datos)) {
                $_SESSION['success'] = 'Pago registrado exitosamente';
            } else {
                $_SESSION['error'] = 'Error al registrar el pago';
            }

            header('Location: index.php?route=admin/dashboard');
            exit;
        }

        $facturas = $this->facturaModel->obtenerTodas();

        return 'views/admin/crear_pago.php';
    }
}
