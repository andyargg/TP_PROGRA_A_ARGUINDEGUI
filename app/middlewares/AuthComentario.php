<?php

require_once './models/Comentario.php';

class AuthComentario{
    public static function ValidarCamposComentario($request, $handler){
        $parametros = $request->getParsedBody();
    
        if (!isset($parametros['mesaId']) || !isset($parametros['puntaje']) || !isset($parametros['comentario'])) {
            throw new Exception('Campos faltantes: mesaId, puntaje o comentario.');
        }
    
        if ($parametros['puntaje'] < 1 || $parametros['puntaje'] > 10) {
            throw new Exception('Puntaje debe estar entre 1 y 10.');
        }
    
        return $handler->handle($request);
    }

    
}

?>