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
    $id = $_GET['id'] ?? null;

    if (!$id) { 
        header("Location: index.php?route=admin/dashboard");
        exit;
    }

    // Obtener la categoría a editar
    $categoria = $this->categoriaModel->obtenerPorId($id);

    // Guardarlo temporalmente para la vista
    $_SESSION['categoria_edit'] = $categoria;

    return "views/admin/editar_categoria.php";
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
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header("Location: index.php?route=admin/dashboard");
        exit;
    }

    $id = $_POST['idCATEGORIA'];

    $datos = [
        'nomCATEGORIA' => $_POST['nomCATEGORIA'],
        'descripcionCATEGORIA' => $_POST['descripcionCATEGORIA']
    ];

    $this->categoriaModel->actualizar($id, $datos);

    $_SESSION['success'] = "Categoría actualizada correctamente";
    header("Location: index.php?route=admin/dashboard");
    exit;
}


}
