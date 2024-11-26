<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

class MesaController extends Mesa implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $mesa = new Mesa();
        $mesa->codigoMesa = Mesa::generarCodigoMesa();
        $mesa->capacidad = $parametros['capacidad'];
        $mesa->estado = $parametros['estado'];
        $mesa->crearMesa();

        $payload = json_encode(array("mensaje" => "Mesa creada con éxito - CODIGO: [ $mesa->codigoMesa ]"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Mesa::obtenerTodos();
        $payload = json_encode(array("listaMesas" => $lista));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args){
        $id = $args['id'];
        $mesa = Mesa::obtenerMesaId($id);
        $payload = json_encode($mesa);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args) {
        $id = $args['id'];
        $parametros = $request->getParsedBody();
        $mesa = Mesa::obtenerMesaId($id);
        
        if (isset($parametros['estado'])) {
            $mesa->estado = $parametros['estado'];  
        }
        if (isset($parametros['capacidad'])) {
            $mesa->capacidad = $parametros['capacidad'];  
        }
        if (isset($parametros['aCobrar'])) {
            $mesa->aCobrar = $parametros['aCobrar']; 
        }
        
        Mesa::modificarMesa($mesa);  
        
        $payload = json_encode(array("mensaje" => "Mesa modificada con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    
    public function BorrarUno($request, $response, $args){
        $parametros = $request->getParsedBody();
        $mesa = Mesa::obtenerMesaId($parametros['id']);
        Mesa::borrarMesa($mesa);
        $payload = json_encode(array("mensaje" => "Mesa borrada con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ObtenerMasUsada($request, $response, $args)
    {
        $pedidos = Pedido::obtenerTodos(); 
        $mesaUsos = []; 

        foreach ($pedidos as $pedido) {
            if (isset($pedido->mesaId)) {
                $mesaId = $pedido->mesaId;
                if (!isset($mesaUsos[$mesaId])) {
                    $mesaUsos[$mesaId] = 0;
                }
                $mesaUsos[$mesaId]++;
            }
        }

        $mesaMasUsada = null;
        $maxUsos = 0;

        foreach ($mesaUsos as $mesaId => $usos) {
            if ($usos > $maxUsos) {
                $maxUsos = $usos;
                $mesaMasUsada = $mesaId;
            }
        }

        $resultado = [
            "mesaId" => $mesaMasUsada,
            "cantidadUsos" => $maxUsos
        ];

        $payload = json_encode($resultado);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

public function ObtenerMenosUsada($request, $response, $args)
{
    $pedidos = Pedido::obtenerTodos(); 
    $mesaUsos = []; 

    foreach ($pedidos as $pedido) {
        if (isset($pedido->mesaId)) {
            $mesaId = $pedido->mesaId;
            if (!isset($mesaUsos[$mesaId])) {
                $mesaUsos[$mesaId] = 0;
            }
            $mesaUsos[$mesaId]++;
        }
    }

    $mesaMenosUsada = null;
    $minUsos = PHP_INT_MAX;

    foreach ($mesaUsos as $mesaId => $usos) {
        if ($usos < $minUsos) {
            $minUsos = $usos;
            $mesaMenosUsada = $mesaId;
        }
    }

    $resultado = [
        "mesaId" => $mesaMenosUsada,
        "cantidadUsos" => $minUsos
    ];

    $payload = json_encode($resultado);
    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');
}
public function ObtenerMesaMayorFacturacion($request, $response, $args)
{
    $pedidos = Pedido::obtenerTodos(); 
    $facturacionPorMesa = [];

    foreach ($pedidos as $pedido) {
        if (isset($pedido->mesaId, $pedido->importe)) {
            $mesa = Mesa::obtenerMesaId($pedido->mesaId);
            if ($mesa->estado == "cerrada") {
                $mesaId = $pedido->mesaId;
                $importe = floatval($pedido->importe * $pedido->cantidad);

                if (!isset($facturacionPorMesa[$mesaId])) {
                    $facturacionPorMesa[$mesaId] = 0;
                }

                $facturacionPorMesa[$mesaId] += $importe;
            }
        }
    }

    $mesaMayorFacturacion = null;
    $mayorFacturacion = 0;

    foreach ($facturacionPorMesa as $mesaId => $facturacion) {
        if ($facturacion > $mayorFacturacion) {
            $mayorFacturacion = $facturacion;
            $mesaMayorFacturacion = $mesaId;
        }
    }

    $resultado = [
        "mesaId" => $mesaMayorFacturacion,
        "facturacionTotal" => $mayorFacturacion
    ];

    $payload = json_encode($resultado);
    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');
}









public function ObtenerMesaMenorFacturacion($request, $response, $args)
{
    $pedidos = Pedido::obtenerTodos(); 
    $facturacionPorMesa = [];

    foreach ($pedidos as $pedido) {
        if (isset($pedido->mesaId, $pedido->importe)) {
            $mesa = Mesa::obtenerMesaId($pedido->mesaId);
            if ($mesa->estado == "cerrada") {
                $mesaId = $pedido->mesaId;
                $importe = floatval($pedido->importe * $pedido->cantidad);

                if (!isset($facturacionPorMesa[$mesaId])) {
                    $facturacionPorMesa[$mesaId] = 0;
                }

                $facturacionPorMesa[$mesaId] += $importe;
            }
        }
    }

    $mesaMenorFacturacion = null;
    $menorFacturacion = PHP_FLOAT_MAX;

    foreach ($facturacionPorMesa as $mesaId => $facturacion) {
        if ($facturacion < $menorFacturacion) {
            $menorFacturacion = $facturacion;
            $mesaMenorFacturacion = $mesaId;
        }
    }

    $resultado = [
        "mesaId" => $mesaMenorFacturacion,
        "facturacionTotal" => $menorFacturacion
    ];

    $payload = json_encode($resultado);
    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');
}


public function ObtenerMesaMayorFacturaIndividual($request, $response, $args)
{
    $pedidos = Pedido::obtenerTodos();
    $mesaMayorFactura = null;
    $mayorImporte = PHP_FLOAT_MIN;

    foreach ($pedidos as $pedido) {
        if (isset($pedido->mesaId, $pedido->importe)) {
            $mesa = Mesa::obtenerMesaId($pedido->mesaId);
            if ($mesa->estado == "cerrada") {
                $importe = floatval($pedido->importe * $pedido->cantidad);

                if ($importe > $mayorImporte) {
                    $mayorImporte = $importe;
                    $mesaMayorFactura = $pedido->mesaId;
                }
            }
        }
    }

    $resultado = [
        "mesaId" => $mesaMayorFactura,
        "mayorImporte" => $mayorImporte
    ];

    $payload = json_encode($resultado);
    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');
}

public function ObtenerMesaMenorFacturaIndividual($request, $response, $args)
{
    $pedidos = Pedido::obtenerTodos(); 
    $mesaMenorFactura = null;
    $menorImporte = PHP_FLOAT_MAX;

    foreach ($pedidos as $pedido) {
        if (isset($pedido->mesaId, $pedido->importe)) {
            $mesa = Mesa::obtenerMesaId($pedido->mesaId);
            if ($mesa->estado == "cerrada") {
                $importe = floatval($pedido->importe * $pedido->cantidad);

                if ($importe < $menorImporte) {
                    $menorImporte = $importe;
                    $mesaMenorFactura = $pedido->mesaId;
                }
            }
        }
    }

    $resultado = [
        "mesaId" => $mesaMenorFactura,
        "menorImporte" => $menorImporte
    ];

    $payload = json_encode($resultado);
    $response->getBody()->write($payload);

    return $response->withHeader('Content-Type', 'application/json');
}
public static function ObtenerCobroEntreDosFechas($request, $response, $args){
    $parametros = $request->getParsedBody();
    $mesaId = $parametros['mesaId'];
    $fechaEntrada = DateTime::createFromFormat('Y-m-d H:i:s', $parametros["fechaEntrada"]);
    $fechaSalida = DateTime::createFromFormat('Y-m-d H:i:s', $parametros["fechaSalida"]);
    if(isset($mesaId)){
        $listaPedidos = Pedido::obtenerPedidosPorMesa($mesaId);
        $mesa = Mesa::obtenerMesaId($mesaId);
        if ($mesa->estado == "cerrada")
        {
            $totalFacturado = 0;
            foreach($listaPedidos as $pedido){
                if($pedido->estado == 'completado'){
                    $fechaPedido = DateTime::createFromFormat('Y-m-d H:i:s', substr($pedido->horaInicio, 0, 19));
                    echo "Fechas comparadas:\n";
                    echo "Pedido: " . $fechaPedido->format('Y-m-d H:i:s') . "\n";
                    echo "Entrada: " . $fechaEntrada->format('Y-m-d H:i:s') . "\n";
                    echo "Salida: " . $fechaSalida->format('Y-m-d H:i:s') . "\n";
                   
                    if ($fechaPedido >= $fechaEntrada && $fechaPedido <= $fechaSalida) {
                        $totalFacturado += $pedido->importe * $pedido->cantidad;
                    }
                }
            }
            $payload = json_encode(array("mensaje" => "Total a facturado entre fechas: [ ".$totalFacturado." ]"));
        }
        else
        {
            $payload = json_encode(array("mensaje" => "La mesa no esta cerrada"));
        }
    }
    else{
        $payload = json_encode(array("mensaje" => "No se encontro la mesa"));
    }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
}


        
    
}
