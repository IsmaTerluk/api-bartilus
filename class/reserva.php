<?php 

    require_once "database/connectionDB.php";

    class Reserva extends ConnectionDB{

        public function postRegisterReserva($json){
            $response = new ResponseHTTP();
            $datos = json_decode($json);
            if(isset($datos->{'cliente'}) && isset($datos->{'barbero'}) && isset($datos->{'fecha'}) && isset($datos->{'horario'}) && isset($datos->{'puntos'}) && isset($datos->{'precio'}) && isset($datos->{'servicios'})){
                
                //Mapeamos todos los datos
                $cliente = $datos->{'cliente'};
                $barbero = $datos->{'barbero'};
                $fecha = $datos->{'fecha'};
                $horario = $datos->{'horario'};
                $estado = 'pendiente';
                $puntos = $datos->{'puntos'};
                $precio = $datos->{'precio'};
                $servicios = $datos->{'servicios'};
                
                //Me trae el ultimo numero de reserva insertado
                $nroreserva = $this->insertReserva($cliente, $barbero, $fecha, $horario, $estado, $puntos, $precio);
                $this->insertServicios($nroreserva, $servicios);
                return $response->exito("Turno reservado satisfactoriamente");
            }else{
                return $response->error400();
            }
        }


        private function insertReserva($cliente, $barbero, $fecha, $horario, $estado, $puntos, $precio){
            $query = "INSERT INTO reserva (numero, empleado, cliente, fecha, horario, estado, puntosacumulados, preciototal)
            VALUES (null, '$barbero', '$cliente', date('$fecha'), '$horario', '$estado', '$puntos', '$precio')";
            return $this->insertGetId($query);
        }

        private function insertServicios($reserva, $servicios){
            foreach($servicios as $servicio){
               $query = "INSERT INTO servicio_reservado (nro_reserva, servicio)
               VALUES('$reserva','$servicio')";
               $this->insert($query);
            } 
        }


        public function deleteReserva($json){
            $response = new ResponseHTTP();
            $datos = json_decode($json);
            if(isset($datos->{'numero'})){
                $reserva = $datos->{'numero'};
                $query = "DELETE FROM reserva WHERE numero='$reserva'";
                if($this->insert($query))
                    return $response->exito("Turno eliminado");
                else
                    return $response->error500();
                
            }else{
                return $response->error400();
            }
        }
               

        
    }


?>