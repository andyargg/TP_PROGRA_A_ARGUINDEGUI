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

    public function ObtenerMasVendido($request, $response, $args)
    {
        try {
            $pedidos = Pedido::obtenerTodos();
            $contadorProductos = $this->ContarProductos($pedidos);
            
            $masVendido = [
                'producto_id' => 0,
                'cantidad_total' => 0
            ];

            foreach ($contadorProductos as $productoId => $cantidad) {
                if ($cantidad > $masVendido['cantidad_total']) {
                    $masVendido = [
                        'producto_id' => $productoId,
                        'cantidad_total' => $cantidad
                    ];
                }
            }

            $producto = Producto::obtenerProducto($masVendido['producto_id']);
            $resultado = [
                "nombre" => $producto->nombre,
                "cantidad_total" => $masVendido['cantidad_total']
            ];

            $payload = json_encode($resultado);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            $payload = json_encode(["error" => "Error al obtener el producto más vendido"]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }
    public function ObtenerMenosVendido($request, $response, $args)
    {
        try {
            $pedidos = Pedido::obtenerTodos();
            $contadorProductos = $this->ContarProductos($pedidos);
            
            if (empty($contadorProductos)) {
                throw new Exception("No hay productos vendidos");
            }

            $menosVendido = [
                'producto_id' => 0,
                'cantidad_total' => PHP_INT_MAX
            ];

            foreach ($contadorProductos as $productoId => $cantidad) {
                if ($cantidad < $menosVendido['cantidad_total']) {
                    $menosVendido = [
                        'producto_id' => $productoId,
                        'cantidad_total' => $cantidad
                    ];
                }
            }

            $producto = Producto::obtenerProducto($menosVendido['producto_id']);
            $resultado = [
                "nombre" => $producto->nombre,
                "cantidad_total" => $menosVendido['cantidad_total']
            ];

            $payload = json_encode($resultado);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e) {
            $payload = json_encode(["error" => "Error al obtener el producto menos vendido"]);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        }
    }

    private function ContarProductos($pedidos)
    {
        $contadorProductos = [];
        
        foreach ($pedidos as $pedido) {
            if (!isset($contadorProductos[$pedido->productoId])) {
                $contadorProductos[$pedido->productoId] = 0;
            }
            $contadorProductos[$pedido->productoId] += $pedido->cantidad;
        }


        return $contadorProductos;
    }

    public static function TraerCancelados($request, $response, $args) {
        $cancelados = Pedido::obtenerTodosCancelados();
    
        $payload = json_encode(["mensaje" => $cancelados]);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerFueraDeTiempo($request, $response, $args){
        $lista = Pedido::obtenerTodos();
        $listaFueraTiempo = [];
        foreach ($lista as $pedido)
        {
            if (isset($pedido->horaFinalizacion))
            {
                echo "entra if";
                $producto = Producto::obtenerProducto($pedido->productoId);
                $inicio = new DateTime($pedido->horaInicio);
                $cierre = new DateTime($pedido->horaFinalizacion);
                $diferencia = $inicio->diff($cierre);
                $minutos = $diferencia->days * 24 * 60;
                $minutos += $diferencia->h * 60;
                $minutos += $diferencia->i;
                if ($minutos >= $producto->tiempoPreparacion)
                    $listaFueraTiempo[] = $pedido;
            }

        }
        $payload = json_encode(array("listaPedidosFueraTiempo" => $listaFueraTiempo));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    
}