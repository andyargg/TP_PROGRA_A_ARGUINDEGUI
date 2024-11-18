<?php

require_once './models/Pedido.php';
require_once './interfaces/IApiUsable.php';
class PedidoController extends Pedido implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $pedido = new Pedido();
        $pedido->mesa_id = $parametros['mesa_id'];
        $pedido->usuario_id = $parametros['usuario_id'];
        $pedido->estado = $parametros['estado'];
        $pedido->crearPedido();

        $payload = json_encode(array("mensaje" => "Pedido creado con éxito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Pedido::obtenerTodos();
        $payload = json_encode(array("listaPedidos" => $lista));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $pedido = Pedido::obtenerPedidoId($id);  
        if ($pedido) {
            $payload = json_encode($pedido);
        } else {
            $payload = json_encode(array("mensaje" => "Pedido no encontrado"));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args)
    {
        $id = $args['id'];
        $exito = Pedido::borrarPedido($id);  
        if ($exito) {
            $payload = json_encode(array("mensaje" => "Pedido borrado con éxito"));
        } else {
            $payload = json_encode(array("mensaje" => "No se pudo borrar el pedido"));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

   
    public function ModificarUno($request, $response, $args){
        $parametros = $request->getParsedBody();
        $id = $args['id'];
        $pedido = Pedido::obtenerPedidoId($id);
       
        if(isset($parametros['cantidad'])){
            $pedido->cantidad = $parametros['cantidad'];
            $producto = Producto::obtenerProducto($parametros['idProducto']);
            $pedido->importe = $producto->precio * $parametros['cantidad'];
        }
        if(isset($parametros['idProducto'])){
            Pedido::modificarPedido($pedido);
       
        $payload = json_encode(array("mensaje" => "Pedido modificado con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
        }
    }
}