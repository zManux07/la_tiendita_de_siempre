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

        // 🔐 VALIDAR CONFIRMACIÓN DE CONTRASEÑA
        if ($_POST['pass'] !== $_POST['pass_confirm']) {
            $_SESSION['error'] = 'Las contraseñas no coinciden';
            header('Location: index.php?route=admin/usuario/crear');
            exit;
        }

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

public function editar()
{
    // Si se envió el formulario (POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id = $_POST['idUSUARIO'];  // ID viene desde el formulario

        $datos = [
            'numdocUSUARIO'      => $_POST['numdocUSUARIO'],
            'tipodocumenUSUARIO' => $_POST['tipodocumenUSUARIO'],
            'nomUSUARIO'         => $_POST['nomUSUARIO'],
            'direcUSUARIO'       => $_POST['direcUSUARIO'],
            'telUSUARIO'         => $_POST['telUSUARIO'],
            'emailUSUARIO'       => $_POST['emailUSUARIO'],
            'cargoUSUARIO'       => $_POST['cargoUSUARIO'],
            'rolUSUARIO'         => $_POST['rolUSUARIO'],
            'pass'               => $_POST['pass'] ?? null
        ];

        // Actualiza el usuario
        $this->usuarioModel->actualizar($id, $datos);

        $_SESSION['success'] = "Usuario actualizado correctamente";
        header("Location: index.php?route=admin/dashboard");
        exit;
    }

    // SI ES GET → cargar datos del usuario
    $id = $_GET['idUSUARIO'] ?? null;
    $usuario = $this->usuarioModel->obtenerPorId($id);

    // Hacer accesible la variable a la vista
    $GLOBALS['usuario'] = $usuario;

    // DEVOLVER la ruta de la vista (no hacer require aquí)
    return "views/admin/editar_usuario.php";
}




public function listar() {
    $usuarios = $this->usuarioModel->obtenerTodos();
    return 'views/admin/listar_usuario.php';
}

public function eliminar() {
    $id = $_GET['id'];
    $this->usuarioModel->eliminar($id);
    header("Location: index.php?route=admin/usuario/listar");

    $resultado = $this->modelo->eliminar($idUsuario);

if ($resultado === true) {
    header("Location: index.php?msg=eliminado");
    exit;
}

if ($resultado === "FACTURAS_ASOCIADAS") {
    header("Location: index.php?error=facturas");
    exit;
}
}

}
