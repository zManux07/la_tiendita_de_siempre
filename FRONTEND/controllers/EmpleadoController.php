<?php

class EmpleadoController {
    private $empleadoModel;

    public function __construct($empleadoModel) {
        $this->empleadoModel = $empleadoModel;
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
                'nombre' => $_POST['nombre'] ?? '',
                'cargo' => $_POST['cargo'] ?? '',
                'correo' => $_POST['correo'] ?? '',
                'telefono' => $_POST['telefono'] ?? '',
                'fecha_ingreso' => $_POST['fecha_ingreso'] ?? date('Y-m-d')
            ];

            if (empty($datos['nombre']) || empty($datos['cargo'])) {
                $_SESSION['error'] = 'Nombre y cargo son requeridos';
                header('Location: index.php?route=admin/empleado/crear');
                exit;
            }

            if ($this->empleadoModel->crear($datos)) {
                $_SESSION['success'] = 'Empleado creado exitosamente';
            } else {
                $_SESSION['error'] = 'Error al crear el empleado';
            }

            header('Location: index.php?route=admin/dashboard');
            exit;
        }

        return 'views/admin/crear_empleado.php';
    }
public function editar() {

    // Cuando se envía el formulario (POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['id_empleado'] ?? null;
        if (!$id) {
            $_SESSION['error'] = "No llegó el ID del empleado";
            header("Location: index.php?route=admin/empleado/listar");
            exit;
        }

        $datos = [
            'nombre' => $_POST['nombre'] ?? '',
            'cargo' => $_POST['cargo'] ?? '',
            'correo' => $_POST['correo'] ?? '',
            'telefono' => $_POST['telefono'] ?? '',
            'fecha_ingreso' => $_POST['fecha_ingreso'] ?? null
        ];

        $this->empleadoModel->actualizar($id, $datos);

        $_SESSION['success'] = "Empleado actualizado correctamente";
        header("Location: index.php?route=admin/empleado/listar");
        exit;
    }

    // Mostrar formulario (GET)
    $id = $_GET['id'] ?? null;
    if (!$id) {
        header("Location: index.php?route=admin/empleado/listar");
        exit;
    }

    $empleado = $this->empleadoModel->obtenerPorId($id);

    return 'views/admin/editar_empleado.php';
}




public function listar() {
    $empleados = $this->empleadoModel->obtenerTodos();
    return 'views/admin/listar_empleado.php';
}

public function eliminar() {
    $id = $_GET['id'];
    $this->empleadoModel->eliminar($id);
    header("Location: index.php?route=admin/empleado/listar");
}


}
