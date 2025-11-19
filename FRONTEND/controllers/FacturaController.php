<?php

class FacturaController {
    private $facturaModel;
    private $detalleSalidaModel;
    private $carritoModel;
    private $productoModel;

    public function __construct($facturaModel, $detalleSalidaModel, $carritoModel, $productoModel) {
        $this->facturaModel = $facturaModel;
        $this->detalleSalidaModel = $detalleSalidaModel;
        $this->carritoModel = $carritoModel;
        $this->productoModel = $productoModel;
    }

    public function procesar() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: index.php?route=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $carrito = $this->carritoModel->obtenerPorUsuario($_SESSION['usuario_id']);

            if (empty($carrito)) {
                $_SESSION['error'] = 'El carrito está vacío';
                header('Location: index.php?route=carrito');
                exit;
            }

            $total = 0;
            foreach ($carrito as $item) {
                $total += $item['precioPRODUCTO'] * $item['cantidad'];
            }

            $idFactura = $this->facturaModel->crear($_SESSION['usuario_id'], $total);

            if ($idFactura) {
                foreach ($carrito as $item) {
                    $this->detalleSalidaModel->crear(
                        $idFactura,
                        $item['idProducto'],
                        $item['cantidad'],
                        $item['precioPRODUCTO']
                    );
                    $this->productoModel->actualizarStock($item['idProducto'], $item['cantidad']);
                }

                $this->carritoModel->limpiar($_SESSION['usuario_id']);
                $_SESSION['success'] = 'Compra realizada exitosamente';
                header('Location: index.php?route=compra_exitosa&id=' . $idFactura);
                exit;
            } else {
                $_SESSION['error'] = 'Error al procesar la compra';
                header('Location: index.php?route=carrito');
                exit;
            }
        }

        return 'views/frontend/carrito.php';
    }

    public function exitosa() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: index.php?route=index');
            exit;
        }

        $factura = $this->facturaModel->obtenerPorId($id);
        $detalles = $this->detalleSalidaModel->obtenerPorFactura($id);

        if (!$factura) {
            header('Location: index.php?route=index');
            exit;
        }

        return 'views/frontend/compra_exitosa.php';
    }
}
