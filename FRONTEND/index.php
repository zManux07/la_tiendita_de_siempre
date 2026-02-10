<?php
session_start();

require_once 'config/Database.php';

require_once 'models/ProductoModel.php';
require_once 'models/CategoriaModel.php';
require_once 'models/ProveedorModel.php';
require_once 'models/UsuarioModel.php';
require_once 'models/CarritoModel.php';
require_once 'models/FacturaModel.php';
require_once 'models/DetalleSalidaModel.php';
require_once 'models/EntradaModel.php';
require_once 'models/EmpleadoModel.php';
require_once 'models/PagoModel.php';
require_once 'models/MensajeModel.php';

require_once 'controllers/HomeController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/ProductoController.php';
require_once 'controllers/CategoriaController.php';
require_once 'controllers/ProveedorController.php';
require_once 'controllers/UsuarioController.php';
require_once 'controllers/CarritoController.php';
require_once 'controllers/FacturaController.php';
require_once 'controllers/EntradaController.php';
require_once 'controllers/EmpleadoController.php';
require_once 'controllers/PagoController.php';
require_once 'controllers/MensajeController.php';

require_once 'controllers/MensajeController.php';
require_once 'controllers/RecuperacionController.php';

$db = new Database();
$conn = $db->connect();

$route = $_GET['route'] ?? 'index';

switch ($route) {
    case 'index':
        $controller = new HomeController(new ProductoModel($conn), new CategoriaModel($conn));
        $view = $controller->index();
        require $view;
        break;

    case 'catalogo':
        $controller = new HomeController(new ProductoModel($conn), new CategoriaModel($conn));
        $view = $controller->catalogo();
        require $view;
        break;

    case 'producto':
        $controller = new HomeController(new ProductoModel($conn), new CategoriaModel($conn));
        $view = $controller->producto();
        require $view;
        break;

    case 'contacto':
        $controller = new HomeController(new ProductoModel($conn), new CategoriaModel($conn));
        $view = $controller->contacto();
        require $view;
        break;

    case 'carrito':
        $controller = new HomeController(new ProductoModel($conn), new CategoriaModel($conn));
        $view = $controller->carrito();
        require $view;
        break;

    case 'auth/login':
        $controller = new AuthController(new UsuarioModel($conn));
        $view = $controller->login();
        require $view;
        break;

    case 'auth/registro':
        $controller = new AuthController(new UsuarioModel($conn));
        $view = $controller->registro();
        require $view;
        break;

    case 'login':
        $controller = new AuthController(new UsuarioModel($conn));
        $view = $controller->login();
        require $view;
        break;

    case 'registro':
        $controller = new AuthController(new UsuarioModel($conn));
        $view = $controller->registro();
        require $view;
        break;

    case 'logout':
        $controller = new AuthController(new UsuarioModel($conn));
        $controller->logout();
        break;

    case 'admin/dashboard':
        require 'views/admin/dashboard.php';
        break;

    case 'admin/producto/crear':
        $controller = new ProductoController(
            new ProductoModel($conn),
            new CategoriaModel($conn),
            new ProveedorModel($conn)
        );
        $data = $controller->crear();
        $categorias = $data['categorias'];
        $proveedores = $data['proveedores'];
        require $data['view'];

        break;

    case 'admin/categoria/crear':
        $controller = new CategoriaController(new CategoriaModel($conn));
        $view = $controller->crear();
        require $view;
        break;

    case 'admin/proveedor/crear':
        $controller = new ProveedorController(new ProveedorModel($conn));
        $view = $controller->crear();
        require $view;
        break;

    case 'admin/usuario/crear':
        $controller = new UsuarioController(new UsuarioModel($conn));
        $view = $controller->crear();
        require $view;
        break;

    case 'admin/entrada/crear':
        $controller = new EntradaController(
            new EntradaModel($conn),
            new ProductoModel($conn),
            new UsuarioModel($conn)
        );
        $view = $controller->crear();
        require $view;
        break;

    case 'admin/empleado/crear':
        $controller = new EmpleadoController(new EmpleadoModel($conn));
        $view = $controller->crear();
        require $view;
        break;

    case 'admin/pago/crear':
        $controller = new PagoController(
            new PagoModel($conn),
            new FacturaModel($conn)
        );
        $data = $controller->crear();
        $facturas = $data['facturas'];
        require $data['view'];
        break;

    // PRODUCTO EDITAR
case 'admin/producto/editar':
    $controller = new ProductoController(
        new ProductoModel($conn),
        new CategoriaModel($conn),
        new ProveedorModel($conn)
    );
    $view = $controller->editar();
    require $view;
    break;

    case 'admin/producto/eliminar':
    $controller = new ProductoController(
        new ProductoModel($conn),
        new CategoriaModel($conn),
        new ProveedorModel($conn)
    );
    $controller->eliminar();
    break;


// CATEGORIA EDITAR
case 'admin/categoria/editar':
    $controller = new CategoriaController(new CategoriaModel($conn));
    $view = $controller->editar();
    require $view;
    break;

    case 'admin/categoria/listar':
    $controller = new CategoriaController(new CategoriaModel($conn));
    $view = $controller->listar();
    require $view;
    break;

    case 'admin/categoria/eliminar':
    $controller = new CategoriaController(new CategoriaModel($conn));
    $controller->eliminar();
    break;

    



// PROVEEDOR EDITAR
case 'admin/proveedor/editar':
    $controller = new ProveedorController(new ProveedorModel($conn));
    $view = $controller->editar();
    require $view;
    break;

    case 'admin/proveedor/eliminar':
    $controller = new ProveedorController(new ProveedorModel($conn));
    $controller->eliminar();
    break;



// USUARIO EDITAR
case 'admin/usuario/editar':
    $controller = new UsuarioController(new UsuarioModel($conn));
    $view = $controller->editar();
    require $view;
    break;

// USUARIO ELIMINAR
case 'admin/usuario/eliminar':
    $controller = new UsuarioController(new UsuarioModel($conn));
    $controller->eliminar();
    break;


// EMPLEADO EDITAR
case 'admin/empleado/editar':
    $controller = new EmpleadoController(new EmpleadoModel($conn));
    $view = $controller->editar();
    require $view;
    break;
    case 'admin/empleado/eliminar':
    $controller = new EmpleadoController(new EmpleadoModel($conn));
    $controller->eliminar();
    break;




    case 'admin/mensajes':
        $controller = new MensajeController(new MensajeModel($conn));
        $view = $controller->listar();
        require $view;
        break;

    case 'carrito/agregar':
        $controller = new CarritoController(new CarritoModel($conn), new ProductoModel($conn));
        $controller->agregar();
        break;

    case 'carrito/actualizar':
        $controller = new CarritoController(new CarritoModel($conn), new ProductoModel($conn));
        $controller->actualizar();
        break;

    case 'carrito/eliminar':
        $controller = new CarritoController(new CarritoModel($conn), new ProductoModel($conn));
        $controller->eliminar();
        break;

    case 'factura/procesar':
        $controller = new FacturaController(
            new FacturaModel($conn),
            new DetalleSalidaModel($conn),
            new CarritoModel($conn),
            new ProductoModel($conn)
        );
        $controller->procesar();
        break;

    case 'compra_exitosa':
        $controller = new FacturaController(
            new FacturaModel($conn),
            new DetalleSalidaModel($conn),
            new CarritoModel($conn),
            new ProductoModel($conn)
        );
        $view = $controller->exitosa();
        require $view;
        break;

    case 'mensaje/enviar':
        $controller = new MensajeController(new MensajeModel($conn));
        $controller->enviar();
        break;


case 'admin/producto/listar':
    require 'views/admin/listar_productos.php';
    break;


case 'admin/proveedor/listar':
    require 'views/admin/listar_proovedores.php';
    break;


case 'admin/usuario/listar':
    require 'views/admin/listar_usuarios.php';
    break;


case 'admin/empleado/listar':
    require 'views/admin/listar_empleados.php';
    break;

    case 'admin/factura/listar':
    $controller = new FacturaController(
        new FacturaModel($conn),
        new DetalleSalidaModel($conn),
        new CarritoModel($conn),
        new ProductoModel($conn)
    );

    $data = $controller->listarAdmin();

    $facturas = $data['facturas'];
    $totalPaginas = $data['totalPaginas'];

    require $data['view'];
    break;

case 'admin/factura/ver':
    $controller = new FacturaController(
        new FacturaModel($conn),
        new DetalleSalidaModel($conn),
        new CarritoModel($conn),
        new ProductoModel($conn)
    );

    $data = $controller->verAdmin();

    $factura  = $data['factura'];
    $detalles = $data['detalles'];

    require $data['view'];
    break;

case 'admin/pagos/ver':
    $controller = new PagoController(
        new PagoModel($conn),
        new FacturaModel($conn)
    );

    $data  = $controller->verPagos();
    $pagos = $data['pagos'];

    require $data['view'];
    break;
    
    case 'recuperar_password':
        require_once 'controllers/RecuperacionController.php';
        $controller = new RecuperacionController($conn);
        $view = $controller->solicitarRecuperacion();
        require $view;
        break;

    case 'recuperar_password/procesar':
        require_once 'controllers/RecuperacionController.php';
        $controller = new RecuperacionController($conn);
        $controller->procesarSolicitud();
        break;

    case 'restablecer_password':
        require_once 'controllers/RecuperacionController.php';
        $controller = new RecuperacionController($conn);
        $view = $controller->mostrarFormularioRestablecimiento();
        require $view;
        break;

    case 'restablecer_password/procesar':
        require_once 'controllers/RecuperacionController.php';
        $controller = new RecuperacionController($conn);
        $controller->restablecerPassword();
        break;


    default:
        header('Location: index.php?route=index');
        exit;




}
