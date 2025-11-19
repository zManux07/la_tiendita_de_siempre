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
}
