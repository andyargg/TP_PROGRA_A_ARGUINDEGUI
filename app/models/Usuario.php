<?php

class Usuario
{
    public $id;
    public $usuario;
    public $clave;
    public $rol;

    public function crearUsuario()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuarios (usuario, clave, rol) VALUES (:usuario, :clave, :rol)");
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, usuario, clave FROM usuarios");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function obtenerUsuario($usuario)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, usuario, clave, rol FROM usuarios WHERE usuario = :usuario");
        $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }
    public static function obtenerUsuarioEmail($email)
    {
        try {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT id, usuario, clave, rol, fecha_creacion, fecha_baja, email FROM usuarios WHERE email = :email");
            $consulta->bindValue(':email', $email, PDO::PARAM_STR);
            $consulta->execute();
        
        return $consulta->fetchObject('Usuario');
        } catch (PDOException $e) {
            echo 'Error al obtener el usuario: ' . $e->getMessage();
        }
    }
   public static function modificarUsuario($id, $usuario, $clave, $rol)
   {
       try {
           $objAccesoDatos = AccesoDatos::obtenerInstancia();
           $consulta = $objAccesoDatos->prepararConsulta("UPDATE usuarios SET usuario = :usuario, clave = :clave, rol = :rol WHERE id = :id");
           
           $consulta->bindValue(':usuario', $usuario, PDO::PARAM_STR);
           $consulta->bindValue(':clave', password_hash($clave, PASSWORD_DEFAULT), PDO::PARAM_STR); 
           $consulta->bindValue(':rol', $rol, PDO::PARAM_STR);
           $consulta->bindValue(':id', $id, PDO::PARAM_INT);
           
           return $consulta->execute();
       } catch (PDOException $e) {
           throw new Exception("Error al modificar el usuario: " . $e->getMessage());
       }
   }



    public static function borrarUsuario($usuario)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuarios SET fecha_baja = :fecha_baja WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $usuario, PDO::PARAM_INT);
        $consulta->bindValue(':fecha_baja', date_format($fecha, 'Y-m-d H:i:s'), PDO::PARAM_STR);
        $consulta->execute();
    }
}