<?php
require_once 'AuthJTW.php';

class AutenticadorUsuario {

    public static function VerificarUsuario($request, $handler){
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        AutenticadorJWT::VerificarToken($token);
        $datos = AutenticadorJWT::ObtenerData($token);

        if(self::ValidarRolUsuario($datos->rol)){
            return $handler->handle($request);
        }
        else{
            throw new Exception('No autorizado');
        }
    }

    public static function ValidarPermisosDeRol($request, $handler, $rol = false){
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);
            
            AutenticadorJWT::VerificarToken($token);
            $datos = AutenticadorJWT::ObtenerData($token);
            if((!$rol && $datos->rol == 'socio') || $rol && $datos->rol == $rol || $datos->rol == 'socio'){
                return $handler->handle($request);
            }
            throw new Exception('Acceso denegado');
        }

        public static function ValidarPermisosDeRolDoble($request, $handler, $rol1 = false, $rol2 = false){
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);

            AutenticadorJWT::VerificarToken($token);
            $datos = AutenticadorJWT::ObtenerData($token);
            if((!$rol1 && $datos->rol == 'socio') || ($rol1 && $datos->rol == $rol1) || ($rol2 && $datos->rol == $rol2) || ($datos->rol == 'socio' || $datos->rol == 'mozo')){
                return $handler->handle($request);
            }
            throw new Exception('Acceso denegado');
        }
    
    public static function ValidarCampos($request, $handler){
        $parametros = $request->getParsedBody();
        if (isset($parametros['usuario']) ||  isset($parametros['clave']) || isset($parametros['rol']) || isset($parametros['email']) ) {
            return $handler->handle($request);
        }
        throw new Exception('Campos inválidos');
    }

    public static function ValidarCampoIdUsuario($request, $handler){
        $parametros = $request->getQueryParams();
        if (isset($parametros['usuarioId'])) {
            return $handler->handle($request);
        }
        throw new Exception('Campo idUsuario no encontrado');
    }

    public static function ValidarRolUsuario($rol){
        return in_array($rol, ['socio', 'bartender', 'cocinero', 'mozo', 'candybar']);
    }
}
