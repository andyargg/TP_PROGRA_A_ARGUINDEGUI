<?php

class OrderStateMiddleware

{
    private $validStates = [
        'pendiente',
        'en_preparacion',
        'listo_para_servir'
    ];

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = new Response();
        $body = $request->getParsedBody();
        
        if (isset($body['estado'])) {
            if (!in_array($body['estado'], $this->validStates)) {
                $response->getBody()->write(json_encode([
                    'error' => 'Invalid order state',
                    'valid_states' => $this->validStates
                ]));
                return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
            }
            
            $body['estado_timestamp'] = date('Y-m-d H:i:s');
            $request = $request->withParsedBody($body);
        }
        
        return $handler->handle($request);
    }
}