<?php

require_once "./models/Pedido.php";

class AuthPedidos{
    public static function ValidarPedidoExistente($request, $handler){
        $parametros = $request->getParsedBody();

        if(isset($parametros['id'])){
            $mesa = Pedido::obtenerPedidoId($parametros['id']);
            if($mesa){
                return $handler->handle($request);
            }
        }
        throw new Exception('Mesa no existente');

    }

    public static function ValidarCamposAlta($request, $handler){
        $parametros = $request->getParsedBody();
        if(isset($parametros['cantidad'], $parametros['mesaId'], $parametros['estado'], $parametros['productoId'])){
            return $handler->handle($request);
        }
        throw new Exception('Campos Invalidos');
    }

    

    public static function ValidarEstado($request, $handler){
        $parametros = $request->getParsedBody();
        if(isset($parametros['id'])){
            $pedido = Pedido::obtenerPedidoId($parametros['id']);

            if($pedido->estado == 'pendiente'){
                return $handler->handle($request);

            } else{
                throw new Exception('El pedido no se puede modificar porque se finalizo la preparacion o fue cancelado');
            }
        }
        throw new Exception('Campos Invalidos');
    }
}