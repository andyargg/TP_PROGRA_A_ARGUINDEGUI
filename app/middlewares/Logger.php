<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class AuthMiddleware
{
    private $allowedRoles;

    public function __construct(array $allowedRoles)
    {
        $this->allowedRoles = $allowedRoles;
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $params = $request->getParsedBody();
        $userRole = $params['rol'] ?? null;

        if (in_array($userRole, $this->allowedRoles)) {
            return $handler->handle($request);
        } else {
            $response = new Response();
            $response->getBody()->write(json_encode(["error" => "Acceso denegado: rol insuficiente"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(403);
        }
    }
}
