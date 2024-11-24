<?php
    require_once './controllers/TransaccionesController.php';
    require_once './middlewares/AuthJTW.php';

    class LogMiddleware
    {
        public static function LogTransaccion($request, $handler)
        {
            $header = $request->getHeaderLine('Authorization');
            $usuarioId = -1; // Usuario no autenticado por defecto

            if (!empty($header)) {
                $parts = explode("Bearer ", $header);
                
                if (isset($parts[1]) && !empty($parts[1])) {
                    try {
                        $token = trim($parts[1]);
                        AutenticadorJWT::VerificarToken($token);
                        $datos = AutenticadorJWT::ObtenerData($token);
                        $usuarioId = $datos->id; 
                    } catch (Exception $e) {
                        $usuarioId = -1;
                    }
                }
            }

            $response = $handler->handle($request);

            $code = $response->getStatusCode();
            $accion = $request->getUri()->getPath();
            TransaccionesController::InsertarTransaccion($usuarioId, $accion, $code);

            return $response;
        }
    }

?>