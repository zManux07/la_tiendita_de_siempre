<?php

class CarritoController {
    private $carritoModel;
    private $productoModel;

    public function __construct($carritoModel, $productoModel) {
        $this->carritoModel = $carritoModel;
        $this->productoModel = $productoModel;
    }

    public function agregar() {
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
            exit;
        }

        $idProducto = $_POST['idProducto'] ?? null;
        $cantidad = $_POST['cantidad'] ?? 1;

        if (!$idProducto) {
            echo json_encode(['success' => false, 'message' => 'Producto inválido']);
            exit;
        }

        if ($this->carritoModel->agregar($_SESSION['usuario_id'], $idProducto, $cantidad)) {
            echo json_encode([
                'success' => true,
                'message' => 'Producto agregado al carrito',
                'cantidad' => $this->carritoModel->contar($_SESSION['usuario_id'])
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al agregar al carrito']);
        }
        exit;
    }

    public function actualizar() {
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
            exit;
        }

        $idCarrito = $_POST['idCarrito'] ?? null;
        $cantidad = $_POST['cantidad'] ?? 1;

        if (!$idCarrito || $cantidad < 1) {
            echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
            exit;
        }

        if ($this->carritoModel->actualizar($idCarrito, $cantidad)) {
            echo json_encode(['success' => true, 'message' => 'Carrito actualizado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
        }
        exit;
    }

    public function eliminar() {
        if (!isset($_SESSION['usuario_id'])) {
            echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
            exit;
        }

        $idCarrito = $_POST['idCarrito'] ?? null;

        if (!$idCarrito) {
            echo json_encode(['success' => false, 'message' => 'ID inválido']);
            exit;
        }

        if ($this->carritoModel->eliminar($idCarrito)) {
            echo json_encode(['success' => true, 'message' => 'Producto eliminado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar']);
        }
        exit;
    }
}
