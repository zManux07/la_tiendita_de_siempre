<?php

class HomeController {
    private $productoModel;
    private $categoriaModel;

    public function __construct($productoModel, $categoriaModel) {
        $this->productoModel = $productoModel;
        $this->categoriaModel = $categoriaModel;
    }

    public function index() {
        $productos = $this->productoModel->obtenerTodos();
        $categorias = $this->categoriaModel->obtenerTodas();

        return 'views/frontend/index.php';
    }

    public function catalogo() {
        $productos = $this->productoModel->obtenerTodos();
        $categorias = $this->categoriaModel->obtenerTodas();
        $categoriaSeleccionada = $_GET['categoria'] ?? null;

        if ($categoriaSeleccionada) {
            $productos = $this->productoModel->obtenerPorCategoria($categoriaSeleccionada);
        }

        return 'views/frontend/catalogo.php';
    }

    public function producto() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?route=catalogo');
            exit;
        }

        $producto = $this->productoModel->obtenerPorId($id);

        if (!$producto) {
            header('Location: index.php?route=catalogo');
            exit;
        }

        return 'views/frontend/producto.php';
    }

    public function contacto() {
        return 'views/frontend/contacto.php';
    }

    public function carrito() {
        return 'views/frontend/carrito.php';
    }
}
