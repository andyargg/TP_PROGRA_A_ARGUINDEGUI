<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class VerificarPermisosABMMiddleware
{
    private $allowedRoles;

    public function __construct(array $allowedRoles)
    {
        $this->allowedRoles = $allowedRoles;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $params = $request->getParsedBody();
        $userRole = $params['role'] ?? null; 
        
        if (in_array($userRole, $this->allowedRoles)) {
            $pedidoId = $params['pedido_id'] ?? null;
            $accion = $params['accion'] ?? null;

            $estadoPedido = $this->getEstadoPedido($pedidoId);

            if ($accion === 'alta') {
                if ($userRole !== 'mesero') {
                    return $this->forbiddenResponse("Solo el mesero puede crear pedidos.");
                }
            } elseif ($accion === 'modificacion') {
                if ($userRole === 'mesero' && $estadoPedido !== 'pendiente') {
                    return $this->forbiddenResponse("El mesero solo puede modificar pedidos en estado pendiente.");
                }
                if ($userRole === 'admin') {
                }
            } elseif ($accion === 'baja') {
                if ($userRole !== 'admin') {
                    return $this->forbiddenResponse("Solo el administrador puede eliminar pedidos.");
                }
                if ($estadoPedido !== 'pendiente') {
                    return $this->forbiddenResponse("Solo los pedidos en estado pendiente pueden eliminarse.");
                }
            }

            return $handler->handle($request);
        } else {
            return $this->forbiddenResponse("Acceso denegado: rol insuficiente.");
        }
    }

    private function forbiddenResponse(string $mensaje): Response
    {
        $response = new Response();
        $response->getBody()->write(json_encode(["error" => $mensaje]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(403);
    }

    private function getEstadoPedido($pedidoId)
    {
        return 'pendiente'; 
    }
}
