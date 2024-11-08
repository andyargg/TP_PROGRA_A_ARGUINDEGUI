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
// require_once './middlewares/Logger.php';

require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/PedidoController.php';
require_once './controllers/MesaController.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$app = AppFactory::create();

// $app->addErrorMiddleware(true, true, true);

// // $app->addBodyParsingMiddleware();

$app->get('[/]', function (Request $request, Response $response) {    
    $payload = json_encode(array("mensaje" => "Slim Framework 4 HOAL"));
    
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
});

$app->group('/usuarios', function (RouteCollectorProxy $group) {
  $group->get('[/]', \UsuarioController::class . ':TraerTodos');
  $group->post('[/]', \UsuarioController::class . ':CargarUno');
  $group->get('/{usuario}', \UsuarioController::class . ':TraerUno');
  $group->put('/{id}', \UsuarioController::class . ':ModificarUno');
  $group->delete('/{id}', \UsuarioController::class . ':BorrarUno');
});

$app->group('/productos', function (RouteCollectorProxy $group) {
  $group->get('[/]', \ProductoController::class . ':TraerTodos');
  $group->get('/{producto}', \ProductoController::class . ':TraerUno');
  $group->post('[/]', \ProductoController::class . ':CargarUno');
  $group->put('/{id}', \ProductoController::class . ':ModificarUno');
  $group->delete('/{id}', \ProductoController::class . ':BorrarUno');
});

$app->group('/mesas', function (RouteCollectorProxy $group) {
  $group->get('[/]', \MesaController::class . ':TraerTodos');
  $group->post('[/]', \MesaController::class . ':CargarUno');
  
});

$app->group('/pedidos', function (RouteCollectorProxy $group) {
  $group->post('[/]', \PedidoController::class . ':CargarUno')
        ->add(new RoleMiddleware(['mesero', 'admin']));
  $group->put('[/]', \PedidoController::class . ':ModificarEstado')
        ->add(new RoleMiddleware(['admin', 'cocinero']));
});













$app->run();
