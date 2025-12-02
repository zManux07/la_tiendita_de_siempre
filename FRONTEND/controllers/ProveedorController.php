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
    public function editar() {

    // Si viene por POST -> guardar cambios
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_GET['id'] ?? $_POST['idPROVEEDOR'] ?? null;

        if (!$id) {
            $_SESSION['error'] = "No se recibió el ID del proveedor";
            header("Location: index.php?route=admin/proveedor/listar");
            exit;
        }

        $datos = [
            'nomPROVEEDOR' => $_POST['nomPROVEEDOR'],
            'telPROVEEDOR' => $_POST['telPROVEEDOR'],
            'direcPROVEEDOR' => $_POST['direcPROVEEDOR']
        ];

        $this->proveedorModel->actualizar($id, $datos);

        $_SESSION['success'] = "Proveedor actualizado correctamente";
        header("Location: index.php?route=admin/proveedor/listar");
        exit;
    }

    // Si viene por GET -> mostrar formulario
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: index.php?route=admin/proveedor/listar");
        exit;
    }

    $proveedor = $this->proveedorModel->obtenerPorId($id);

    return "views/admin/editar_proveedor.php";
}

public function listar() {
    $proveedores = $this->proveedorModel->obtenerTodos();
    return 'views/admin/listar_proveedor.php';
}

public function eliminar() {
    $id = $_GET['id'];
    $this->proveedorModel->eliminar($id);
    header("Location: index.php?route=admin/proveedor/listar");
}


}
