<?php

require_once './models/Pedido.php';
require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';
class PedidoController extends Pedido implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        
        $codigoPedido = $parametros['codigoPedido'];
        $mesaId = $parametros['mesaId'];
        $productoId = $parametros['productoId'];
        $cantidad = $parametros['cantidad'];

        $producto = Producto::obtenerProducto($productoId);
        
        $pedido = new Pedido();
        $pedido->codigoPedido = $codigoPedido;
        $pedido->productoId = $productoId;
        $pedido->sector = self::ChequearSector($producto->tipo);
        $pedido->cantidad = $cantidad;
        $pedido->importe = $cantidad * $producto->precio;
        $pedido->mesaId = $mesaId;

        $pedido->crearPedido();

        $payload = json_encode(array("mensaje" => self::ChequearSector($producto->tipo)));

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
        $id = $parametros['id'];
        $pedido = Pedido::obtenerPedidoId($id);
       
        if(isset($parametros['cantidad'])){
            $pedido->cantidad = $parametros['cantidad'];
            $producto = Producto::obtenerProducto($pedido->productoId);
            $pedido->importe = $producto->precio * $parametros['cantidad'];
        }
    
        if(isset($parametros['mesaId'])){
            $pedido->mesaId = $parametros['mesaId'];
        }
    
        if(isset($parametros['productoId'])){
            $pedido->productoId = $parametros['productoId'];
            $producto = Producto::obtenerProducto($pedido->productoId);
            $pedido->importe = $producto->precio * $pedido->cantidad;
        }
    
        if(isset($parametros['sector'])){
            $pedido->sector = $parametros['sector'];
        }
        if(isset($parametros['importe'])){
            $pedido->importe = $parametros['importe'];
        }
    
        if(isset($parametros['estado'])){
            $pedido->estado = $parametros['estado'];
            if ($parametros['estado'] == "completado"){
                $pedido->horaFinalizacion = (new DateTime('now'))->format('Y-m-d H:i:s');
            }
        }

    
        Pedido::modificarPedido($pedido);
    
        $payload = json_encode(array("mensaje" => "Pedido modificado con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function ChequearSector($tipo){
        if($tipo === 'comida'){
            return 'cocina';
        }
        else if($tipo === 'bebida'){
            return 'barra';
        }
        else if($tipo === 'postre'){
            return 'candybar';
        }
    }
    public static function DescargarCSV($request, $response, $args) {
        $pedidos = Pedido::obtenerTodosFinalizados('completado');
        $fecha = new DateTime(date('Y-m-d'));
        $path = date_format($fecha, 'Y-m-d').'pedidos_completados.csv';
        $archivo = fopen($path, 'w');
        $encabezado = array('id','sector','mesaId','estado','horaInicio','horaFinalizacion','importe','codigoPedido','productoId','cantidad');
        fputcsv($archivo, $encabezado);
        
        foreach($pedidos as $pedido){
            $linea = array($pedido->id, $pedido->sector, $pedido->mesaId, $pedido->estado, $pedido->horaInicio, $pedido->horaFinalizacion, $pedido->importe, $pedido->codigoPedido, $pedido->productoId, $pedido->cantidad);
            fputcsv($archivo, $linea);
        }
        $payload = json_encode(array("mensaje" => 'Archivo de Pedidos del dia de la fecha creado exitosamente'));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    public static function EntregarPedidoFinalizado($request, $response, $args) {
        $pedidoId = $args['pedidoId'];
        Pedido::LlevarPedido($pedidoId);
        $payload = json_encode(array("mensaje" => 'Pedido completado'));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}