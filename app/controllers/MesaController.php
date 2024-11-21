<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';

class MesaController extends Mesa implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $mesa = new Mesa();
        $mesa->codigoMesa = $parametros['codigoMesa'];
        $mesa->capacidad = $parametros['capacidad'];
        $mesa->estado = $parametros['estado'];
        $mesa->crearMesa();

        $payload = json_encode(array("mensaje" => "Mesa creada con éxito"));
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
        
    
}
