<?php

require_once './models/Transacciones.php';
require_once './models/Usuario.php';

class TransaccionesController{
    public function GetTransacciones($request, $response, $args)
    {
        $transacciones = Transaccion::TraerTodo();
        $payload = json_encode(["transacciones" => $transacciones]);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function InsertarTransaccion($usuarioId, $accion, $code)
{
    try {
        $logTransaccion = new Transaccion();
        $logTransaccion->usuarioId = $usuarioId;
        $logTransaccion->code = $code;
        $logTransaccion->accion = $accion;

        if ($accion == '/login' && $code == 200) {
            $logTransaccion->accion = $accion . ' (inicio exitoso)';
        }

        return $logTransaccion->Insertar();
    } catch (Exception $e) {
        error_log("Error al insertar transacción: " . $e->getMessage());
        return false;
    }
}

public static function CalcularCantidadOperaciones($request, $response, $args) 
{
    $sectores = Usuario::ObtenerSectores();
    $transacciones = Transaccion::TraerTodo();
    
    foreach ($transacciones as $transaccion) {
        $usuario = Usuario::obtenerUsuario($transaccion->usuarioId);
        if ($usuario && !empty($usuario->rol)) {
            if (!isset($sectores[$usuario->rol])) {
                $sectores[$usuario->rol] = 0;
            }
            $sectores[$usuario->rol]++;
        }
    }
    
    if (isset($sectores[''])) {
        unset($sectores['']);
    }
    
    $payload = json_encode(["cantidadOperaciones" => $sectores]);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
}

    public function CalcularCantidadOperacionesUsuarios($request, $response, $args)
    {
        $sectores = [];
        $transacciones = Transaccion::TraerTodo(); 
        foreach ($transacciones as $transaccion)
        {
            $usuario = Usuario::obtenerUsuario($transaccion->usuarioId);
            if ($usuario) { 
                $rol = $usuario->rol ?: 'sin_rol'; 
                if (!isset($sectores[$rol])) {
                    $sectores[$rol] = [];
                }
                if (!isset($sectores[$rol][strval($usuario->id)])) {
                    $sectores[$rol][strval($usuario->id)] = 1;
                } else {
                    $sectores[$rol][strval($usuario->id)] += 1;
                }
            } else {
                if (!isset($sectores['usuarios_no_encontrados'])) {
                    $sectores['usuarios_no_encontrados'] = [];
                }
                if (!isset($sectores['usuarios_no_encontrados'][$transaccion->usuarioId])) {
                    $sectores['usuarios_no_encontrados'][$transaccion->usuarioId] = 1;
                } else {
                    $sectores['usuarios_no_encontrados'][$transaccion->usuarioId] += 1;
                }
            }
        }

        $payload = json_encode(["cantidadOperaciones" => $sectores]);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}



