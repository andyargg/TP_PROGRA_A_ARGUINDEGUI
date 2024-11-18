<?php
    require_once './models/Usuario.php';
    require_once './models/RegistroLogin.php';
    require_once 'AuthJTW.php';
    class Logger
    {
        public static function LogOperacion($request, $response, $next)
        {
            $retorno = $next($request, $response);
            return $retorno;
        }

        private static function RegistrarLogin($idUsuario)
        {
            $registroLogin = new RegistroLogin();
            $registroLogin->idUsuario = $idUsuario;
            $registroLogin->CrearRegistroLogin();
        }

        public static function Loguear($request, $response, $args){
            $parametros = $request->getParsedBody();
            $email = $parametros['email'];
            $clave = $parametros['clave'];
            $usuario = Usuario::obtenerUsuarioEmail($email);
            if($usuario !== null){
                $token = AutenticadorJWT::CrearToken(array('id' => $usuario->id, 'usuario' => $usuario->usuario, 'email' => $usuario->email, 'rol' => $usuario->rol));
                $payload = json_encode(array(
                    'mensaje' => 'Logueo Exitoso - Usted es: [ '.$usuario->rol.' ]',
                    'token' => $token
                ));
                Logger::RegistrarLogin($usuario->id);
            }
            else{
                $payload = json_encode(array('mensaje'=>$usuario->email));
            }
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public static function Salir($request, $response, $args){
            $payload = json_encode(array('mensaje'=>'Sesion Cerrada'));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }

        public static function ValidarSesionIniciada($request, $handler)
        {
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);

            if ($token) {
                    $datos = AutenticadorJWT::ObtenerData($token);
                    return $handler->handle($request);
            }

            throw new Exception('Debe haber iniciado sesión');
        }
    }

?>