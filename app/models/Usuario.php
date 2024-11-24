<?php

class Usuario
{
    public $id;
    public $usuario;
    public $clave;
    public $rol;
    public $email;
    public $estado;
    public $fecha_creacion;
    public $fecha_baja;

    public function crearUsuario()
    {
        $fecha = new DateTime(date('Y-m-d H:i:s'));
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuarios (usuario, email, clave, rol, estado, fecha_creacion, fecha_baja) VALUES (:usuario, :email, :clave, :rol, :estado, :fecha_creacion, :fecha_baja)");
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':rol', $this->rol, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
        $consulta->bindValue(':estado', 'activo', PDO::PARAM_STR);
        $consulta->bindValue(':email', $this->email, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_creacion', date_format($fecha, 'Y-m-d H:i:s'), PDO::PARAM_STR);
        $consulta->bindValue(':fecha_baja', null, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function obtenerUsuario($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);

        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }
    public static function obtenerUsuarioEmail($email)
    {
        try {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM usuarios WHERE email = :email");
            $consulta->bindValue(':email', $email, PDO::PARAM_STR);
            $consulta->execute();
        
        return $consulta->fetchObject('Usuario');
        } catch (PDOException $e) {
            echo 'Error al obtener el usuario: ' . $e->getMessage();
        }
    }
   public static function modificarUsuario($usuario)
   {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE usuarios SET usuario = :usuario, clave = :clave, email = :email, rol = :rol, estado = :estado WHERE id = :id");
        $consulta->bindValue(':id', $usuario->id, PDO::PARAM_INT);
        $consulta->bindValue(':usuario', $usuario->usuario, PDO::PARAM_STR);
        $consulta->bindValue(':email', $usuario->email, PDO::PARAM_STR);
        $consulta->bindValue(':clave', $usuario->clave, PDO::PARAM_STR);
        $consulta->bindValue(':rol', $usuario->rol, PDO::PARAM_STR);
        $consulta->bindValue(':estado', $usuario->estado, PDO::PARAM_STR);
        
        $consulta->execute();
   }



   public static function borrarUsuario($usuario)
   {
       $objAccesoDato = AccesoDatos::obtenerInstancia();
       $consulta = $objAccesoDato->prepararConsulta("UPDATE usuarios SET fecha_baja = :fecha_baja, estado = 'inactivo' WHERE id = :id");
       $fecha = new DateTime();
       $consulta->bindValue(':id', $usuario, PDO::PARAM_INT);
       $consulta->bindValue(':fecha_baja', $fecha->format('Y-m-d H:i:s'), PDO::PARAM_STR);
       $consulta->execute();
   }
   public static function ObtenerSectores()
    {
        $sectores = [];
        $usuarios = Usuario::obtenerTodos();

        foreach ($usuarios as $usuario)
        {
            $sectores[$usuario->rol] = 0;
        }

        return $sectores;
    }
   
}