<?php

class ProveedorController {
    private $proveedorModel;

    public function __construct($proveedorModel) {
        $this->proveedorModel = $proveedorModel;
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
                'nomPROVEEDOR' => $_POST['nomPROVEEDOR'] ?? '',
                'telPROVEEDOR' => $_POST['telPROVEEDOR'] ?? '',
                'direcPROVEEDOR' => $_POST['direcPROVEEDOR'] ?? '',
                'emailPROVEEDOR' => $_POST['emailPROVEEDOR'] ?? ''
            ];

            if (empty($datos['nomPROVEEDOR'])) {
                $_SESSION['error'] = 'El nombre del proveedor es requerido';
                header('Location: index.php?route=admin/proveedor/crear');
                exit;
            }

            if ($this->proveedorModel->crear($datos)) {
                $_SESSION['success'] = 'Proveedor creado exitosamente';
            } else {
                $_SESSION['error'] = 'Error al crear el proveedor';
            }

            header('Location: index.php?route=admin/dashboard');
            exit;
        }

        return 'views/admin/crear_proveedor.php';
    }
}
