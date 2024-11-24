<?php

class RegistroLogin{
    public $id;
    public $usuarioId;
    public $fechaConexion;
    
    public function CrearRegistroLogin(){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO registrologin (usuarioId, fechaConexion) VALUES (:usuarioId, :fechaConexion)");
        $fecha = new DateTime(date('Y-m-d H:i:s'));

        $consulta->bindValue(':usuarioId', $this->usuarioId, PDO::PARAM_INT);
        $consulta->bindValue(':fechaConexion', date_format($fecha, 'Y-m-d H:i:s'), PDO::PARAM_STR);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function ObtenerTodos(){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM registrologin");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'RegistroLogin');
    }

    public static function ObtenerPorUsuario($usuarioId){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM registrologin WHERE usuarioId = :usuarioId");
        $consulta->bindValue(':usuarioId', $usuarioId, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'RegistroLogin');
    }

    public static function ObtenerRegistroLogin($id){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM registrologin WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('RegistroLogin');
    }

    public static function ModificarRegistroLogin($fechaConexion){
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE registrologin SET fechaConexion = :fechaConexion, usuarioId = :usuarioId WHERE id = :id");
        $consulta->bindValue(':id', $fechaConexion->id, PDO::PARAM_INT);
        $consulta->bindValue(':usuarioId', $fechaConexion->usuarioId, PDO::PARAM_INT);
        $consulta->bindValue(':fechaConexion', $fechaConexion->fechaConexion, PDO::PARAM_STR);
        $consulta->execute();
    }

    public static function BorrarRegistroLogin($fechaConexion){
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("DELETE FROM registrologin WHERE id = :id");
        $consulta->bindValue(':id', $fechaConexion->id, PDO::PARAM_INT);
        $consulta->execute();
    }
    
}