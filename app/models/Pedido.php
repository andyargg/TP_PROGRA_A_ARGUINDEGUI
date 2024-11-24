<?php

class Pedido
{
    public $id;
    public $codigoPedido;
    public $mesaId;
    public $productoId;
    public $sector;
    public $estado;
    public $importe;
    public $cantidad;
    public $horaInicio;
    public $horaFinalizacion;

    public function crearPedido()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO pedidos (codigoPedido, mesaId, productoId, sector, estado, importe, cantidad, horaInicio, horaFinalizacion) VALUES (:codigoPedido, :mesaId, :productoId, :sector, :estado, :importe, :cantidad, :horaInicio, :horaFinalizacion)");
        $fecha = new DateTime(date('Y-m-d H:i:s'));
        $consulta->bindValue(':codigoPedido', $this->codigoPedido, PDO::PARAM_STR);
        $consulta->bindValue(':mesaId', $this->mesaId, PDO::PARAM_INT);
        $consulta->bindValue(':productoId', $this->productoId, PDO::PARAM_INT);
        $consulta->bindValue(':sector', $this->sector, PDO::PARAM_STR);
        $consulta->bindValue(':estado', 'pendiente', PDO::PARAM_STR);
        $consulta->bindValue(':importe', $this->importe, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);     
        $consulta->bindValue(':horaInicio', date_format($fecha, 'Y-m-d H:i:s'), PDO::PARAM_STR);
        $consulta->bindValue(':horaFinalizacion', null, PDO::PARAM_STR);
        $consulta->execute();
        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }


    public static function modificarPedido($pedido, $productoIdNuevo = false)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("UPDATE pedidos SET mesaId = :mesaId, productoId = :productoId, sector = :sector, importe = :importe, cantidad = :cantidad, estado = :estado, horaFinalizacion = :horaFinalizacion WHERE id = :id");
        $consulta->bindValue(':id', $pedido->id, PDO::PARAM_INT);
        $consulta->bindValue(':mesaId', $pedido->mesaId, PDO::PARAM_INT);
        $consulta->bindValue(':productoId', $pedido->productoId, PDO::PARAM_INT);
        $consulta->bindValue(':sector', $pedido->sector, PDO::PARAM_STR);
        $consulta->bindValue(':importe', $pedido->importe, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $pedido->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':horaFinalizacion', $pedido->horaFinalizacion, PDO::PARAM_INT);
        if($productoIdNuevo){
            $nuevoProducto = Producto::obtenerProducto($productoIdNuevo);
            $consulta->bindValue(':productoId', $pedido->productoId, PDO::PARAM_INT);
            $consulta->bindValue(':importe', $nuevoProducto->precio * $pedido->cantidad , PDO::PARAM_INT);
        }
        
        $consulta->bindValue(':estado', $pedido->estado, PDO::PARAM_STR);
        echo $pedido->importe;
        $consulta->execute();
    }

    public static function borrarPedido($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("DELETE FROM pedidos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
    }
    public static function obtenerPedidoId($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchObject('Pedido');
    }
    public static function obtenerTodosFinalizados()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos WHERE estado = :estado");
        $consulta->bindValue(':estado', "completado", PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

    public static function obtenerPedidosPorMesa($mesaId)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos WHERE mesaId = :mesaId");
        $consulta->bindValue(':mesaId', $mesaId, PDO::PARAM_INT);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }
    public static function obtenerTodosPorSector($sector){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos WHERE sector = :sector AND estado = :estado");
        $consulta->bindValue(':sector', $sector, PDO::PARAM_STR);
        $consulta->bindValue(':estado', 'pendiente', PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }
    public static function completarPedido($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE pedidos SET estado = :estado WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':estado', 'completado', PDO::PARAM_STR);
        $consulta->execute();
    }

    public static function obtenerTodosCancelados(){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM pedidos WHERE  estado = :estado");
        $consulta->bindValue(':estado', 'cancelado', PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
    }

}

