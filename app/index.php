<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';
require_once './middlewares/Logger.php';
require_once './middlewares/AuthMesas.php';
require_once './middlewares/AuthJTW.php';
require_once './middlewares/AuthPedidos.php';
require_once './middlewares/AuthProductos.php';
require_once './middlewares/AuthUsuario.php';
require_once './middlewares/TransaccionMW.php';

require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/PedidoController.php';
require_once './controllers/MesaController.php';
require_once './controllers/TransaccionesController.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$app = AppFactory::create();
$app->addErrorMiddleware(true, true, true);
$app->addBodyParsingMiddleware();

$app->get('[/]', function (Request $request, Response $response) {    
    $payload = json_encode(array("mensaje" => "Slim Framework 4 PHP"));
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

//ruta sesion
$app->group('/sesion', function (RouteCollectorProxy $group) {
    $group->post('[/]', \Logger::class.'::Loguear');
    $group->get('[/]', \Logger::class.'::Salir');
});

// rutas de usuarios
$app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->get('[/]', \UsuarioController::class . ':TraerTodos');

    $group->get('/cantidad-operaciones', \TransaccionesController::class . ':CalcularCantidadOperaciones');

    $group->get('/cantidad-operaciones-usuarios', \TransaccionesController::class . ':CalcularCantidadOperacionesUsuarios');

    $group->get('/registro-login', \UsuarioController::class . ':ObtenerRegistroLogin');

    $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');

    $group->post('[/]', \UsuarioController::class . ':CargarUno')
          ->add(\AutenticadorUsuario::class . ':ValidarCampos');

    $group->put('/{id}', \UsuarioController::class . ':ModificarUno');

    $group->delete('/{id}', \UsuarioController::class . ':BorrarUno');
})
->add(\AutenticadorUsuario::class . ':ValidarPermisosDeRol')
->add(\Logger::class.':ValidarSesionIniciada');

// rutas de productos
$app->group('/productos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \ProductoController::class . ':TraerTodos');

    $group->get('/{id}', \ProductoController::class . ':TraerUno');

    $group->post('[/]', \ProductoController::class . ':CargarUno')
        ->add(\AuthProductos::class . ':ValidarCamposProductos')
        ->add(\AutenticadorUsuario::class.':ValidarPermisosDeRol')
        ->add(\Logger::class.':ValidarSesionIniciada');

    $group->put('/{id}', \ProductoController::class . ':ModificarUno')  
        ->add(\AuthProductos::class . ':ValidarCamposProductos')
        ->add(\AutenticadorUsuario::class.':ValidarPermisosDeRol')
        ->add(\Logger::class.':ValidarSesionIniciada');

    $group->delete('/{id}', \ProductoController::class . ':BorrarUno')
        ->add(\AutenticadorUsuario::class.':ValidarPermisosDeRol')
        ->add(\Logger::class.':ValidarSesionIniciada');
});

// rutas de mesas
$app->group('/mesas', function (RouteCollectorProxy $group) {
    $group->get('[/]', \MesaController::class . ':TraerTodos')
        ->add(\AutenticadorUsuario::class . ':ValidarPermisosDeRolDoble');

    $group->get('/{id}', \MesaController::class . ':TraerUno')
        ->add(\AutenticadorUsuario::class.':ValidarPermisosDeRolDoble');

    $group->post('[/]', \MesaController::class . ':CargarUno')
        ->add(\AutenticadorUsuario::class . ':ValidarPermisosDeRol');

    $group->put('[/{id}]', \MesaController::class . ':ModificarUno')
        ->add(\AuthMesas::class . ':ValidarMesa')
        ->add(\AutenticadorUsuario::class . ':ValidarPermisosDeRol');

    $group->delete('[/]', \MesaController::class . ':BorrarUno')
        ->add(\AuthMesas::class . ':ValidarMesa')
        ->add(\AutenticadorUsuario::class . ':ValidarPermisosDeRol');
})
->add(\Logger::class.':ValidarSesionIniciada');


//ruta de pedidos
$app->group('/pedidos', function (RouteCollectorProxy $group) {
    $group->get('[/]', \PedidoController::class . ':TraerTodos')
        ->add(\AutenticadorUsuario::class . ':ValidarPermisosDeRolDoble');

    $group->get('/mas-vendido', \PedidoController::class.':ObtenerMasVendido')
        ->add(\AutenticadorUsuario::class.':ValidarPermisosDeRol');
    $group->get('/menos-vendido', \PedidoController::class.':ObtenerMenosVendido')
        ->add(\AutenticadorUsuario::class.':ValidarPermisosDeRol');

    $group->get('/fuera-de-tiempo', \PedidoController::class.':TraerFueraDeTiempo')
        ->add(\AutenticadorUsuario::class.':ValidarPermisosDeRol');

    $group->get('/id', \PedidoController::class.':TraerUno')
        ->add(\AutenticadorUsuario::class.':ValidarPermisosDeRolDoble');

    $group->get('/cancelados', \PedidoController::class.':TraerCancelados')
        ->add(\AutenticadorUsuario::class.':ValidarPermisosDeRolDoble');

    $group->post('[/]', \PedidoController::class . ':CargarUno')
        ->add(\AuthPedidos::class . ':ValidarCamposAlta')
        ->add(function ($request, $handler) {
            return \AutenticadorUsuario::ValidarPermisosDeRol($request, $handler, 'mozo');
        });
    $group->put('[/]', \PedidoController::class.':ModificarUno')
        ->add(\AuthPedidos::class.':ValidarEstado');

    $group->delete('[/]', \PedidoController::class.':BorrarUno')
        ->add(\AutenticadorUsuario::class.':ValidarPermisosDeRol');

    })
->add(\Logger::class.':ValidarSesionIniciada');

//ruta archivos
$app->group('/archivos', function (RouteCollectorProxy $group) {
    $group->post('/cargarProductos', \ProductoController::class . ':CargarCSV');
    $group->get('/descargarPedidos', \PedidoController::class .':DescargarCSV');
    $group->get('/descargarUsuarios', \UsuarioController::class . ':DescargarPDF');
})
->add(\AutenticadorUsuario::class.':ValidarPermisosDeRol')
->add(\Logger::class.':ValidarSesionIniciada');

$app->add(LogMiddleware::class . ':LogTransaccion');


$app->run();