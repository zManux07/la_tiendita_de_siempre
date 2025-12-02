<?php

class CategoriaController {
    private $categoriaModel;

    public function __construct($categoriaModel) {
        $this->categoriaModel = $categoriaModel;
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
                'nomCATEGORIA' => $_POST['nomCATEGORIA'] ?? '',
                'descripcionCATEGORIA' => $_POST['descripcionCATEGORIA'] ?? ''
            ];

            if (empty($datos['nomCATEGORIA'])) {
                $_SESSION['error'] = 'El nombre de la categoría es requerido';
                header('Location: index.php?route=admin/categoria/crear');
                exit;
            }

            if ($this->categoriaModel->crear($datos)) {
                $_SESSION['success'] = 'Categoría creada exitosamente';
            } else {
                $_SESSION['error'] = 'Error al crear la categoría';
            }

            header('Location: index.php?route=admin/dashboard');
            exit;
        }

        return 'views/admin/crear_categoria.php';
    }
public function editar() {

    // 1) Si viene por POST -> procesar la actualización
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // ID viene por la URL (GET) en la acción del form o como hidden en POST
        $id = $_GET['id'] ?? $_POST['idCATEGORIA'] ?? null;

        if (!$id) {
            $_SESSION['error'] = "No se recibió el ID de la categoría";
            header("Location: index.php?route=admin/categoria/listar");
            exit;
        }

        // Leer los campos que vienen del formulario
        $datos = [
            'nomCATEGORIA' => $_POST['nomCATEGORIA'] ?? '',
            'descripcionCATEGORIA' => $_POST['descripcionCATEGORIA'] ?? ''
        ];

        // Actualiza en la BD
        $this->categoriaModel->actualizar($id, $datos);

        // Mensaje y redirección a la lista
        $_SESSION['success'] = "Categoría actualizada correctamente";
        header("Location: index.php?route=admin/categoria/listar");
        exit;
    }

    // 2) Si viene por GET -> mostrar el formulario con datos
    $id = $_GET['id'] ?? null;
    if (!$id) {
        header("Location: index.php?route=admin/categoria/listar");
        exit;
    }

    // obtener la categoría y cargar la vista
    $categoria = $this->categoriaModel->obtenerPorId($id);
    // (opcional) evita usar SESSION para pasar datos; la vista puede leer $categoria directamente
    // si tu index.php/dispatcher espera que el controlador retorne la ruta:
    return 'views/admin/editar_categoria.php';
}



public function listar() {
    $categorias = $this->categoriaModel->obtenerTodas();
    return 'views/admin/listar_categoria.php';
}


public function eliminar() {
    $id = $_GET['id'];
    $this->categoriaModel->eliminar($id);
    header("Location: index.php?route=admin/listar_categoria.php");
}
public function actualizar() {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: index.php?route=admin/dashboard");
        exit;
    }

    $datos = [
        'nomCATEGORIA' => $_POST['nomCATEGORIA'],
        'descripcionCATEGORIA' => $_POST['descripcionCATEGORIA']
    ];

    $this->categoriaModel->actualizar($id, $datos);

    header("Location: index.php?route=admin/categoria/listar");
    exit;
}




}
