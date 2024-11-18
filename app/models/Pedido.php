<?php

class Pedido
{
    public $id;
    public $mesa_id;
    public $usuario_id;
    public $estado;
    public $fecha_pedido; 

    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (mesa_id, usuario_id, fecha_pedido, estado) VALUES (:mesa_id, :usuario_id, :fecha_pedido, :estado)");
        $consulta->bindValue(':mesa_id', $this->mesa_id, PDO::PARAM_INT);
        $consulta->bindValue(':usuario_id', $this->usuario_id, PDO::PARAM_INT);
        $consulta->bindValue(':fecha_pedido', date("Y-m-d"), PDO::PARAM_STR); 
        $consulta->bindValue(':estado', $this->estado, PDO::PARAM_STR);
        $consulta->execute();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function obtenerPedidoId($id){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function modificarPedido($pedido)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET mesaId = :mesaId, productoId = :productoId, nombreCliente = :nombreCliente, sector = :sector, importe = :importe, cantidad = :cantidad, estado = :estado WHERE id = :id");
        $consulta->bindValue(':id', $pedido->id, PDO::PARAM_INT);
        $consulta->bindValue(':mesaId', $pedido->mesaId, PDO::PARAM_INT);
        $consulta->bindValue(':productoId', $pedido->productoId, PDO::PARAM_INT);
        $consulta->bindValue(':nombreCliente', $pedido->nombreCliente, PDO::PARAM_STR);
        $consulta->bindValue(':sector', $pedido->sector, PDO::PARAM_STR);
        $consulta->bindValue(':importe', $pedido->importe, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $pedido->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':estado', $pedido->estado, PDO::PARAM_STR);

        $consulta->execute();
    }

    public static function borrarPedido($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("DELETE FROM pedidos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
    }
}

