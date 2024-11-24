<?php
    class Transaccion
    {
        public $nroTransaccion;
        public $fecha;
        public $usuarioId;
        public $code;
        public $accion;

        public function Insertar()
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $fecha = new DateTime(date('Y-m-d H:i:s'));
    
            // Primero verificar si el usuario existe
            $consultaUsuario = $objAccesoDatos->prepararConsulta("
                SELECT id FROM usuarios WHERE id = :usuarioId
            ");
            $consultaUsuario->bindValue(':usuarioId', $this->usuarioId, PDO::PARAM_INT);
            $consultaUsuario->execute();
            
            if (!$consultaUsuario->fetch()) {
                throw new Exception("El usuario con ID {$this->usuarioId} no existe");
            }
    
            $consulta = $objAccesoDatos->prepararConsulta("
                INSERT INTO logTransacciones (fecha, usuarioId, accion, code) 
                VALUES (:fecha, :usuarioId, :accion, :code)
            ");
    
            $consulta->bindValue(':fecha', date_format($fecha, 'Y-m-d H:i:s'), PDO::PARAM_STR);
            $consulta->bindValue(':usuarioId', $this->usuarioId, PDO::PARAM_INT);
            $consulta->bindValue(':code', $this->code, PDO::PARAM_INT);
            $consulta->bindValue(':accion', $this->accion, PDO::PARAM_STR);
            
            $consulta->execute();
            return $objAccesoDatos->obtenerUltimoId();
        }
        

        public static function TraerTodo()
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM logtransacciones");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_CLASS, 'Transaccion');
        }

        public static function TraerUnLog($nroTransaccion)
        {
            $objAccesoDatos = AccesoDatos::obtenerInstancia();
            
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM logTransacciones WHERE nroTransaccion = :nroTransaccion");
            
            $consulta->bindValue(':nroTransaccion', $nroTransaccion, PDO::PARAM_STR);
            $consulta->execute();
            
            $resultado = $consulta->fetchObject('logTransaccion');
            if ($resultado === false)
                return null;

            return $resultado;
        }

        public static function ExportarCSV($path = "./datos/logTransacciones.csv")
        {
            $logTransacciones = LogTransaccion::TraerTodo();

            $archivo = fopen($path, 'w');
            
            $encabezado = ['nroTransaccion', 'fecha', 'usuarioId', 'code', 'accion'];
            fputcsv($archivo, $encabezado);
            
            foreach ($logTransacciones as $logTransaccion) {
                $datos = [$logTransaccion->nroTransaccion, $logTransaccion->fecha, $logTransaccion->usuarioId, $logTransaccion->code, $logTransaccion->accion];
                fputcsv($archivo, $datos);
            }
            fclose($archivo);
        }
    }
?>