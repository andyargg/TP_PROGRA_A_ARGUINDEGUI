<?php
require_once './models/Comentario.php';
require_once './interfaces/IApiUsable.php';

class ComentarioController extends Comentario implements IApiUsable{
    
    public function TraerUno($request, $response, $args){
        $parametros = $request->getQueryParams();
        $id = $parametros['id'];
        $prd = Comentario::obtenerComentario($id);
        $payload = json_encode($prd);

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args){
        $lista = Comentario::obtenerTodos();
        $payload = json_encode(array("listaComentario" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerMejores($request, $response, $args){
        $lista = Comentario::obtenerTodos();
        $lista_mejores = [];
    
        foreach ($lista as $comentario) {
            if ($comentario->puntaje >= 7) {
                $lista_mejores[] = $comentario;    
            }
        }
    
        $payload = json_encode(array("listaComentario" => $lista_mejores));
    
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerPeores($request, $response, $args){
        $lista = Comentario::obtenerTodos();
        $lista_peores = [];
    
        foreach ($lista as $comentario) {
            if ($comentario->puntaje <= 3) {
                $lista_peores[] = $comentario;    
            }
        }
    
        $payload = json_encode(array("listaComentario" => $lista_peores));
    
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    

    public function CargarUno($request, $response, $args){
        $parametros = $request->getParsedBody();

        $mesaId = $parametros['mesaId'];
        $puntaje = $parametros['puntaje'];
        $comentario = $parametros['comentario'];
        $prd = new Comentario();
        $prd->mesaId = $mesaId;
        $prd->puntaje = $puntaje;
        $prd->comentario = $comentario;
        $prd->crearComentario();

        $payload = json_encode(array("mensaje" => "Comentario creado con exito"));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function BorrarUno($request, $response, $args){
        $parametros = $request->getParsedBody();
        Comentario::borrarComentario($parametros['id']);
        $payload = json_encode(array("mensaje" => "Comentario borrado con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function ModificarUno($request, $response, $args){
        $parametros = $request->getParsedBody();
        
        $comentario = Comentario::obtenerComentario($parametros['id']);

        if(isset($parametros['mesaId'])){
            $comentario->mesaId = $parametros['mesaId'];
        }
        if(isset($parametros['puntaje'])){
            $comentario->puntaje = $parametros['puntaje'];
        }
        if(isset($parametros['comentario'])){
            $comentario->comentario = $parametros['comentario'];
        }
    
        Comentario::modificarComentario($comentario);
        $payload = json_encode(array("mensaje" => "Comentario modificado con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
}