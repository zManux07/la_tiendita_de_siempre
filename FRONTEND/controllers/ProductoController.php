<?php

class ProductoController {
    private $productoModel;
    private $categoriaModel;
    private $proveedorModel;

    public function __construct($productoModel, $categoriaModel, $proveedorModel) {
        $this->productoModel = $productoModel;
        $this->categoriaModel = $categoriaModel;
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
                'nomPRODUCTO' => $_POST['nomPRODUCTO'] ?? '',
                'marcaPRODUCTO' => $_POST['marcaPRODUCTO'] ?? '',
                'precioPRODUCTO' => $_POST['precioPRODUCTO'] ?? 0,
                'cantidadenstockPRODUCTO' => $_POST['cantidadenstockPRODUCTO'] ?? 0,
                'unidadMedidaPRODUCTO' => $_POST['unidadMedidaPRODUCTO'] ?? '',
                'idCATEGORIA' => $_POST['idCATEGORIA'] ?? null,
                'idPROVEEDOR' => $_POST['idPROVEEDOR'] ?? null
            ];

            if (!empty($_FILES['fotoPRODUCTO']['name'])) {

                $archivo = $_FILES['fotoPRODUCTO'];

    // Validar tipo de archivo
                    $permitidos = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!in_array($archivo['type'], $permitidos)) {
        $_SESSION['error'] = 'El archivo debe ser JPG o PNG';
        header('Location: index.php?route=admin/producto/crear');
        exit;
    }

    // Validar tamaño (5MB máximo)
    if ($archivo['size'] > 5 * 1024 * 1024) {
        $_SESSION['error'] = 'La imagen no debe superar los 5MB';
        header('Location: index.php?route=admin/producto/crear');
        exit;
    }

    // Nombre único
    $nombre = uniqid() . '_' . basename($archivo['name']);
    $ruta = 'assets/img/' . $nombre;

    // Mover archivo
    if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
        $datos['fotoPRODUCTO'] = $ruta;
                }
            }

            if ($this->productoModel->crear($datos)) {
                $_SESSION['success'] = 'Producto creado exitosamente';
            } else {
                $_SESSION['error'] = 'Error al crear el producto';
            }

            header('Location: index.php?route=admin/dashboard');
            exit;
        }

        $categorias = $this->categoriaModel->obtenerTodas();
        $proveedores = $this->proveedorModel->obtenerTodos();

        return 'views/admin/crear_producto.php';
    }
}
