<?php
require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        
        $nombre = $parametros['nombre'];
        $precio = $parametros['precio'];
        $tipo = $parametros['tipo'];
        $tiempoPreparacion = $parametros['tiempoPreparacion'];
        $cantidad = $parametros['cantidad']; 

        $producto = new Producto();
        $producto->nombre = $nombre;
        $producto->precio = $precio;
        $producto->tipo = $tipo;
        $producto->tiempoPreparacion = $tiempoPreparacion;
        $producto->cantidad = $cantidad; 
        $producto->crearProducto();

        $payload = json_encode(array("mensaje" => "Producto creado con éxito"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function TraerUno($request, $response, $args)
    {
        $id = $args['id'];
        $producto = Producto::obtenerProducto($id);
        $payload = json_encode($producto);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    public function TraerTodos($request, $response, $args)
    {
        $lista = Producto::obtenerTodos();
        $payload = json_encode(array("listaProductos" => $lista));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args)
    {
        $id = $args['id'];
        $parametros = $request->getParsedBody();
        $producto = Producto::obtenerProducto($id);
        if(isset($parametros['nombre'])){
            $producto->nombre = $parametros['nombre'];
        }
        if(isset($parametros['tipo'])){
            $producto->tipo = $parametros['tipo'];
        }
        if(isset($parametros['precio'])){
            $producto->precio = $parametros['precio'];
        }
        if(isset($parametros['tiempoPreparacion'])){
            $producto->tiempoPreparacion = $parametros['tiempoPreparacion'];
        }
        if(isset($parametros['cantidad'])){
            $producto->cantidad = $parametros['cantidad'];
        }
        Producto::modificarProducto($producto);
        $payload = json_encode(array("mensaje" => "Producto modificado con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
   

    public function BorrarUno($request, $response, $args)
    {
        $id = $args['id'];
        Producto::borrarProducto($id);
        
        $payload = json_encode(array("mensaje" => "Producto borrado con éxito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function CargarCSV($request, $response, $args) {
        $parametros = $request->getUploadedFiles();
        $archivo = fopen($parametros['archivo']->getFilePath(), 'r');
        $encabezado = fgetcsv($archivo);
        echo "hola";
        while(($datos = fgetcsv($archivo)) !== false){
            $producto = new Producto();
            $producto->nombre = $datos[0];
            $producto->tipo = $datos[1];
            $producto->precio = $datos[2];
            $producto->cantidad = $datos[3];
            $producto->tiempoPreparacion = $datos[4];
            
            $producto->crearProducto();
        }
        fclose($archivo);
        $payload = json_encode(array("mensaje" => "Lista de productos cargada exitosamente"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
